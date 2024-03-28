<?php

namespace App\Http\Controllers\Admin;


use App\Models\Project;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Arr;
use Illuminate\Validation\Rule;

class ProjectController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {

        $filter = $request->query('filter');
        $query = Project::orderByDesc('updated_at')->orderByDesc('created_at');

        if($filter){
            $value = $filter === 'published';
            $query->whereIsPublished($value);
        }

        $projects = $query->paginate(10)->withQueryString();
        return view('admin.projects.index', compact('projects', 'filter'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $project = new Project();
        return view('admin.projects.create', compact('project'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {

        $request->validate([
            'title' => 'required|string|min:1|max:30|unique:projects',
            'content' => 'required|string',
            'image' => 'nullable|image',
            'is_published' => 'nullable|boolean',
        ],
        [
            'title.required' => 'Il titolo è obbligatorio',
            'title.min' => 'Il titolo deve essere composto da almeno :min caratteri',
            'title.max' => 'Il titolo deve essere composto al massimo da :max caratteri',
            'title.unique' => 'Non possono esserci due progetti con lo stesso titolo',
            'content.required' => 'Il contenuto è obbligatorio',
            'image.image' => 'Il file inserito non è un\'immagine',
            'is_published.boolean' => 'Il valore del campo di pubblicazione non è valido',

        ]);

        $data = $request->all();

        $project = new Project();

        $project->fill($data);
        $project->slug = Str::slug($project->title);
        $project->is_published = Arr::exists($data, 'is_published');

        if(Arr::exists($data, 'image')){

            if($project->image) Storage::delete($project->image);
            $extensions = $data['image']->extension();

            $img_url = Storage::putFileAs('project_images', $data['image'], "$project->slug.$extensions");
            $project->image = $img_url;
        }

        $project->save();

        return to_route('admin.projects.show', $project)->with('message','Progetto creato con successo')->with('type', 'success');
    }

    /**
     * Display the specified resource.
     */
    public function show(Project $project)
    {
        return view('admin.projects.show', compact('project'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Project $project)
    {
        return view('admin.projects.edit', compact('project'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Project $project)
    {

        $request->validate([
            'title' => ['required', 'string', 'min:1', 'max:30', Rule::unique('projects')->ignore($project->id)],
            'content' => ['required', 'string'],
            'image' => ['nullable', 'image'],
            'is_published' => ['nullable', 'boolean'],
        ],
        [
            'title.required' => 'Il titolo è obbligatorio',
            'title.min' => 'Il titolo deve essere composto da almeno :min caratteri',
            'title.max' => 'Il titolo deve essere composto al massimo da :max caratteri',
            'title.unique' => 'Non possono esserci due progetti con lo stesso titolo',
            'content.required' => 'Il contenuto è obbligatorio',
            'image.image' => 'Il file inserito non è un\'immagine',
            'is_published.boolean' => 'Il valore del campo di pubblicazione non è valido',
            
        ]);

        $data = $request->all();

        $data['slug'] = Str::slug($data['title']);
        $data['is_published'] = Arr::exists($data, 'is_published');

        if(Arr::exists($data, 'image')){

            if($project->image) Storage::delete($project->image);
            $extensions = $data['image']->extension();

            $img_url = Storage::putFileAs('project_images', $data['image'], "{$data['slug']}.$extensions");
            $project->image = $img_url;
        }

        $project->update($data);

        return to_route('admin.projects.show', $project)->with('message','Progetto modificato con successo')->with('type', 'success');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Project $project)
    {
        $project->delete();

        return to_route('admin.projects.index')
            ->with('toast-button-type', 'danger')
            ->with('toast-message', 'Project eliminato')
            ->with('toast-label', config('app.name'))
            ->with('toast-method', 'PATCH')
            ->with('toast-route', route('admin.projects.restore', $project->id))
            ->with('toast-button-label', 'Annulla');
    }
    
    // * Rotte Soft Delete
    
    public function trash(){
        $projects = Project::onlyTrashed()->get();
        return view('admin.projects.trash', compact('projects'));
    }
    
    public function restore(Project $project){
        $project->restore();
        return to_route('admin.projects.index')->with('type', 'success')->with('message', 'Progetto ripristinato con successo');
    }
    
    public function drop(Project $project){

        if($project->image) Storage::delete($project->image);
        $project->forceDelete();

        return to_route('admin.projects.trash')->with('type', 'warning')->with('message', 'Progetto eliminato definitivamente con successo');
    }

    // * Rotta toggle switch in index
    public function toggle(Project $project){
        $project->is_published = !$project->is_published;

        $action = $project->is_published ? 'pubblicato' : 'salvato come bozza';
        $type = $project->is_published ? 'success' : 'info';

        $project->save();

        return back()->with('message', "Il progetto $project->title è stato $action")->with('type', $type);
    }
}