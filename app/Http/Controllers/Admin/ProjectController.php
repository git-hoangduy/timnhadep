<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use File;

use App\Models\Project;
use App\Models\ProjectImage;
use App\Models\ProjectBlock;
use App\Models\ProjectCategory;

class ProjectController extends Controller
{
    private $PATH_IMAGE = 'uploads/projects/';

    public function index(Request $request)
    {
        $query = Project::query();

        if (!empty($request->keyword)) {
            $query->where(function ($q) use ($request) {
                $q->where('name','LIKE','%'.$request->keyword.'%')
                ->orWhere('meta_keywords', 'like', '%' . $request->keyword . '%')
                ->orWhere('meta_description', 'like', '%' . $request->keyword . '%');
            });
        }

        if (!empty($request->category)) {
            $query->where('category_id', $request->category);
        }

        $projects = $query->orderBy('id', 'desc')->paginate(20);
        $categories = ProjectCategory::where(['status' => 1, 'level' => 1])->get();

        return view('admin.project.index', compact('projects', 'categories'));
    }

    public function create()
    {
        $categories = ProjectCategory::where(['status' => 1, 'level' => 1])->get();
        return view('admin.project.create', compact('categories'));
    }

    public function store(Request $request)
    {
        $this->validate($request, [
            'name' => 'required',
        ]);

        $data = [
            'category_id' => $request->category_id,
            'name' => $request->name,
            'price' => $request->price,
            'position' => $request->position,
            'excerpt' => $request->excerpt,
            'status' => $request->status,
        ];
        $slug  = Str::slug($data['name']);
        $check = Project::where('slug', $slug)->first();
        if(!empty($check)){
            $slug = $slug.'-'.time();
        }
        $data['slug'] = $slug;

        $project = Project::create($data);

        if($project){

            if($request->hasFile('images')) {

                foreach($request->file('images') as $key => $file){
                    $fileExtension = $file->getClientOriginalExtension();
                    $fileName = $file->getClientOriginalName();
                    $fileNameHash = md5(time().$data['slug'].$key).'.'.$fileExtension;
                    $file->move($this->PATH_IMAGE, $fileNameHash);
                    ProjectImage::create([
                        'project_id' => $project->id,
                        'image' => $this->PATH_IMAGE.$fileNameHash,
                        'name' => $fileName,
                    ]);
                }

                if (!empty($request->is_avatar)) {
                    ProjectImage::where(['project_id' => $project->id, 'name' => $request->is_avatar])->update(['is_avatar' => 1]);
                }
            }

            if (!empty($request->block_content)) {

                foreach($request->block_content as $key => $block_content) {
    
                    $projectBlock = ProjectBlock::create([
                        'project_id' => $project->id,
                        'block_content' => $block_content,
                        'block_name' => $request->block_name[$key],
                    ]);
    
                    if (!empty($projectBlock)) {
    
                        if ($request->hasFile("block_image.{$key}")) {
                            $file = $request->file("block_image.{$key}");
                            $fileExtension = $file->getClientOriginalExtension();
                            $fileName = md5(time().$projectBlock->id.$key).'.'.$fileExtension;
                            $file->move($this->PATH_IMAGE, $fileName);
        
                            $projectBlock->block_image = $this->PATH_IMAGE.$fileName;
                            $projectBlock->save();
                        }
                    }
                }
            }

            request()->session()->flash('success', 'Thêm dự án thành công');
        }
        else{
            request()->session()->flash('error', 'Đã xảy ra lỗi, xin hãy thử lại!');
        }
        return redirect()->route('project.index');

    }

    public function edit($id)
    {
        $project = Project::find($id);
        $categories = ProjectCategory::where(['status' => 1, 'level' => 1])->get();
        return view('admin.project.edit', compact('project', 'categories'));
    }

    public function update(Request $request, $id)
    {
        $project = Project::findOrFail($id);

        $this->validate($request, [
            'name' => 'required',
        ]);

        $data = [
            'category_id' => $request->category_id,
            'name' => $request->name,
            'price' => $request->price,
            'position' => $request->position,
            'excerpt' => $request->excerpt,
            'status' => $request->status,
        ];
        
        $slug  = Str::slug($data['name']);
        $check = Project::where(['slug' => $slug])->where('id', '<>', $id)->first();
        if(!empty($check)){
            $slug = $slug.'-'.time();
        }
        $data['slug'] = $slug;

        if($project->fill($data)->save()){

            if (!empty($request->removeImages)) {
                $removeImages = array_filter(explode(',', $request->removeImages));
                $projectImages = ProjectImage::whereIn('id', $removeImages)->get();
                foreach($projectImages as $image) {
                    if(File::exists($image->image)){
                        File::delete($image->image);
                    }
                    $image->delete();
                }
                
            }

            if ($request->hasFile('images')) {

                foreach($request->file('images') as $key => $file){
                    $fileExtension = $file->getClientOriginalExtension();
                    $fileName = $file->getClientOriginalName();
                    $fileNameHash = md5(time().$data['slug'].$key).'.'.$fileExtension;
                    $file->move($this->PATH_IMAGE, $fileNameHash);

                    ProjectImage::create([
                        'project_id' => $project->id,
                        'image' => $this->PATH_IMAGE.$fileNameHash,
                        'name' => $fileName
                    ]);
                }
            }

            if (!empty($request->is_avatar)) {
                ProjectImage::where(['project_id' => $project->id])->update(['is_avatar' => 0]);
                ProjectImage::where(['project_id' => $project->id, 'name' => $request->is_avatar])->update(['is_avatar' => 1]);
            }

            if (!empty($request->removeBlocks)) {
                $removeBlocks = array_filter(explode(',', $request->removeBlocks));
                foreach($removeBlocks as $removeBlockId) {
                    $projectBlock = ProjectBlock::find($removeBlockId);
                    if(File::exists($projectBlock->block_image)){
                        File::delete($projectBlock->block_image);
                    }
                    $projectBlock->delete();
                }
            }

            if (!empty($request->block_content)) {

                foreach($request->block_content as $key => $block_content) {

                    if ($request->block_id[$key] != '') {

                        $projectBlock = ProjectBlock::find($request->block_id[$key]);
                        $projectBlock->block_content = $block_content;
                        $projectBlock->save();

                    } else {
                        $projectBlock = ProjectBlock::create([
                            'project_id' => $project->id,
                            'block_content' => $block_content,
                            'block_name' => $request->block_name[$key],
                        ]);

                    }
    
                    if (!empty($projectBlock)) {
                        if ($request->hasFile("block_image.{$key}")) {

                            if ($projectBlock->block_image != '') {
                                if(File::exists($projectBlock->block_image)){
                                    File::delete($projectBlock->block_image);
                                }
                            }

                            $file = $request->file("block_image.{$key}");
                            $fileExtension = $file->getClientOriginalExtension();
                            $fileName = md5(time().$projectBlock->id.$key).'.'.$fileExtension;
                            $file->move($this->PATH_IMAGE, $fileName);
        
                            $projectBlock->block_image = $this->PATH_IMAGE.$fileName;
                            $projectBlock->save();
                        }
                    }
                }
            }

            request()->session()->flash('success', 'Cập nhật dự án thành công');
        }
        else{
            request()->session()->flash('error', 'Đã xảy ra lỗi, xin hãy thử lại!');
        }
        return redirect()->route('project.index');
    }

    public function destroy($id)
    {
        $project = Project::findOrFail($id);
        if($project->delete()){

            $projectBlocks = ProjectBlock::where('project_id', $id)->get();
            foreach($projectBlocks as $projectBlock) {
                if(File::exists($projectBlock->block_image)){
                    File::delete($projectBlock->block_image);
                }
                $projectBlock->delete();
            }

            request()->session()->flash('success','Xóa dự án thành công');
        }
        else{
            request()->session()->flash('error','Đã xảy ra lỗi, xin hãy thử lại!');
        }
        return redirect()->route('project.index');
    }

    public function massUpdate(Request $request) {

        $data = json_decode($request->getContent(), true);
        $result['success'] = false;

        if (!empty($data)) {
            foreach($data as $item) {
                Project::where('id', $item['id'])->update($item);
            }
            $result['success'] = true;
        }

        return response()->json($result);
    }
}
