<?php

namespace App\Http\Controllers;

use App\Models\Listing;
use App\Models\Tag;
use App\Models\User;
use  App\Models\Click;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use ParsedownExtra;

class ListingController extends Controller
{
    public function index(Request $request)
    {
        $query = Listing::query()
            ->where('est_active', true)
            ->with('tags')
            ->latest();

        if ($request->has('s')) {
            $searchQuery = trim($request->get('s'));

            $query->where(function (Builder $builder) use ($searchQuery) {
                $builder
                    ->orWhere('title', 'like', "%{$searchQuery}%")
                    ->orWhere('compagny', 'like', "%{$searchQuery}%")
                    ->orWhere('location', 'like', "%{$searchQuery}%");
            });
        }

        if ($request->has('tag')) {
            $tag = $request->get('tag');
            $query->whereHas('tags', function (Builder $builder) use ($tag) {
                $builder->where('slug', $tag);
            });
        }

        $listings = $query->get();

        $tags = Tag::orderBy('name')
            ->get();

        return view('listings.index', compact('listings', 'tags'));
    }

    public function show(Listing $listing, Request $request)
    {
        return view('listings.show', compact('listing'));
    }

    /**
     * Summary of apply
     * @param \App\Models\Listing $listing
     * @param \Illuminate\Http\Request $request on recuperer l'ip de l'utilisateur au click
     * @return \Illuminate\Http\RedirectResponse|mixed
     */
    public function apply(Listing $listing, Request $request)
    {
        $listing->clicks()
            ->create([
                'user_agent' => $request->userAgent(),
                'ip' => $request->ip()
            ]);

        return redirect()->to($listing->lien);
    }

    public function create()
    {
        return view('listings.create');
    }

    public function store(Request $request)
    {
        // proceder a une nouvelle ajoute de service
        $validationArray = [
            'title' => 'required',
            'compagny' => 'required',
            'logo' => 'file|max:2048',
            'location' => 'required',
            'lien' => 'required|url',
            'content' => 'required',
            'payment_method_id' => 'required'
        ];

        if (!Auth::check()) {
            $validationArray = array_merge($validationArray, [
                'email' => 'required|email|unique:users',
                'password' => 'required|confirmed|min:5',
                'name' => 'required'
            ]);
        }

        $request->validate($validationArray);

        //est ce que l'utilisateur est connecter sinon creer et connecter
        $user = Auth::user();

        if (!$user) {
            $user = User::create([
                'name' => $request->name,
                'email' => $request->email,
                'password' => Hash::make($request->password)
            ]);

            $user->createAsStripeCustomer();

            Auth::login($user);
        }

        // on procede au payment et au listage
        try {
            $amount = 599; //
            if ($request->filled('tres_recherche')) {
                $amount += 200;
            }

            $user->charge($amount, $request->payment_method_id);

            $md = new ParsedownExtra();

            $listing = $user->listings()
                ->create([
                    'title' => $request->title,
                    'slug' => Str::slug($request->title) . '-' . rand(1111, 9999),
                    'compagny' => $request->compagny,
                    'logo' => basename($request->file('logo')->store('public')),
                    'location' => $request->location,
                    'lien' => $request->lien,
                    'content' => $md->text($request->input('content')),
                    'tres_recherche' => $request->filled('tres_recherche'),
                    'est_active' => true
                ]);

            foreach (explode(',', $request->tags) as $requestTag) {
                $tag = Tag::firstOrCreate([
                    'slug' => Str::slug(trim($requestTag))
                ], [
                    'name' => ucwords(trim($requestTag))
                ]);

                $tag->listings()->attach($listing->id);
            }

            return redirect()->route('dashboard');
        } catch (\Exception $e) {
            return redirect()->back()
                ->withErrors(['error' => $e->getMessage()]);
        }
    }
}
