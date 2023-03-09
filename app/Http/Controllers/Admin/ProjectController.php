<?php

namespace App\Http\Controllers\Admin;
use App\Http\Controllers\Controller;
use App\Models\Project;
use App\Models\Type;
use App\Models\Technology;
use Illuminate\Support\Facades\Storage;
use App\Http\Requests\StoreProjectRequest;
use App\Http\Requests\UpdateProjectRequest;
use Illuminate\Support\Facades\Auth;
use App\Mail\MailObject;
use App\Models\Lead;
use Illuminate\Support\Favades\Mail;

class ProjectController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $technologies = Technology::all();
        $projects = Project::all();
        return view('admin.projects.index', compact('projects', 'technologies'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $technologies = Technology::all();
        $types = Type::all();
        return view('admin.projects.create', compact('types', 'technologies'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \App\Http\Requests\StoreProjectRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreProjectRequest $request)
    {

       

        $form_data = $request->validated();
        $slug = Project::createSlug($request->title, '-');
        $form_data['slug'] = $slug;
        if($request->has('image')){
            $path = Storage::disk('public')->put('project_images', $request->image);
            $form_data['image'] = $path;
        } 

        $newProject = Project::create($form_data);
        


        if($request->has('technologies')){
            $newProject->technologies()->attach($request->technologies);
        }
        
        $newLead = new Lead();
        $newLead->title = $form_data['title'];
        $newLead->content = $form_data['content'];
        $newLead->slug = $form_data['slug'];
        $newLead->save();

        Mail::to('info@boolpress.com')->send(new MailObject($newLead));

        return redirect()->route('admin.projects.index');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Project  $project
     * @return \Illuminate\Http\Response
     */
    public function show(Project $project)
    {
        return view('admin.projects.show', compact('project'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Project  $project
     * @return \Illuminate\Http\Response
     */
    public function edit(Project $project)
    {
        $technologies = Technology::all();
        $types = Type::all();
        return view('admin.projects.edit', compact('project','types', 'technologies'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Http\Requests\UpdateProjectRequest  $request
     * @param  \App\Models\Project  $project
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateProjectRequest $request, Project $project)
    {
       $form_data = $request->validated();
    
       $slug = Project::createSlug($request->title, '-');
   
       $form_data['slug'] = $slug;

       if($request->has('image')){
       
        if($project->image){
            Storage::delete($project->image);  
        }
        $path = Storage::disk('public')->put('project_images', $request->image);
        
        $form_data['image'] = $path;
    }
   
       $project->update($form_data);

       if($request->has('technologies')){
      
        $project->technologies()->sync($request->technologies);
    }
       
       return redirect()->route('admin.projects.index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Project  $project
     * @return \Illuminate\Http\Response
     */
    public function destroy(Project $project)
    {
        $project->delete();
        return redirect()->route('admin.projects.index');
    }
}
