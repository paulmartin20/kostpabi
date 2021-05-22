<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Space;
use App\Models\User;
use Illuminate\Support\Facades\Storage;

class SpaceController extends Controller
{
    public function __construct()
    {
      $this->middleware(['auth']);
    }
    public function index()
    {
      $space = Space::orderBy('created_at', 'desc')->paginate(4);
      return view('pages.space.index', compact('space'));
    }

    public function create()
    {
      return view('pages.space.create');
    }

    public function browse()
    {
      return view('pages.space.browse');
    }

    public function store(Request $request)
    {
      $this->validate($request, [
        'title' => 'required',
        'address' => 'required',
        'description' => 'required',
        'latitude' => 'required',
        'longitude' => 'required',
        'photo.*' => 'required|image|mimes:jpeg,png,jpg,|max:2048',
      ]);

      $space = $request->user()->spaces()->create($request->except('photo'));

      $spacePhotos = [];

      foreach ($request->file('photo') as $file) {
        $path = Storage::disk('public')->putFile('spaces', $file);
        $spacePhotos[] = [
          'space_id' => $space->id,
          'path' => $path
        ];
      }

      $space->photos()->insert($spacePhotos);

      return redirect()->route('space.index')->with('status', 'space created');
    }

    public function show(Request $request, $id)
    {
      $space = Space::findOrFail($id);
      return view('pages.space.show', compact('space'));
    }

    public function edit($id)
    {
      $space = Space::findOrFail($id);
      if ($space->user_id != request()->user()->id) {
        return redirect()->back();
      }else {
        return view('pages.space.edit', compact('space'));
      }
    }

    public function update(Request $request, $id)
    {
      $space = Space::findOrFail($id);
      if ($space->user_id != request()->user()->id) {
        return redirect()->back();
      }
      $this->validate($request, [
        'title' => 'required',
        'address' => 'required',
        'description' => 'required',
        'latitude' => 'required',
        'longitude' => 'required'
        // 'photo' => ['required'],
        // 'photo.*' => ['mimes:jpg,png']
      ]);
      $space->update($request->all());
      return redirect()->route('space.index')->with('status', 'space updated');
    }

    public function destroy($id)
    {
      $space = Space::findOrFail($id);
      if ($space->user_id != request()->user()->id) {
          return redirect()->back();
      }

      foreach ($space->photos as $photo) {
        Storage::delete('public/'.$photo->path);
      }

      $space->delete();
      return redirect()->route('space.index')->with('status', 'Space deleted!');
    }
}
