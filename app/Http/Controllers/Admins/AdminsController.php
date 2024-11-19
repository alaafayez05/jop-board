<?php

namespace App\Http\Controllers\Admins;


use App\Models\job\job;
use App\Models\Admin\Admin;
use Illuminate\Http\Request;
use App\Models\job\application;
use App\Models\category\category;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\File;


class AdminsController extends Controller
{
    public function viewLogin()
    {
        return view("admins.view-login");
    }

    public function checkLogin(Request $request)
    {

        $remember_me = $request->has('remember_me') ? true : false;

        if (auth()->guard('admin')->attempt(['email' => $request->input("email"), 'password' => $request->input("password")], $remember_me)) {

            return redirect()->route('admins.dashboard');
        }
        return redirect()->back()->with(['error' => 'error logging in']);
    }

    public function index()
    {
        $jobs = Job::select()->count();
        $categories = Category::select()->count();
        $admins = Admin::select()->count();
        $application = Application::select()->count();

        return view("admins.index", compact('jobs', 'categories', 'admins', 'application'));
    }

    public function admins()
    {
        $admins = Admin::all();


        return view("admins\all-admin", compact('admins',));
    }


    public function createAdmins()
    {

        return view('admins/create-admin');
    }

    public function storeAdmins(Request $request)
    {
        $request->validate([
            'name' => 'required|max:40',
            'email' => 'required|max:40',
            'password' => 'required',

        ]);
        $createAdmins = Admin::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
        ]);

        if ($createAdmins) {
            return redirect('admin/all-admins/')->with('create', 'Admin created successfully');
        };
    }



    public function displayCategories()
    {
        $categories = Category::all();

        return view('admins/display-categories', compact('categories'));
    }


    public function createCategories()
    {


        return view('admins/create-categories');
    }
    public function storeCategories(Request $request)
    {
        Request()->validate([
            'name' => 'required|max:40',


        ]);
        $createCategry = Category::create([
            'name' => $request->name,

        ]);

        if ($createCategry) {
            return redirect('admin/display-categories')->with('create', 'Category created successfully');
        };
    }
    public function editCategories($id)
    {
        $category = Category::find($id);



        return view('admins/edit-categories', compact('category'));
    }


    public function updateCategories(Request $request, $id)
    {
        // Validate the incoming request
        Request()->validate([
            'name' => 'required|max:40',
        ]);

        // Find the category by ID
        $categoryUpdate = Category::find($id);

        // Check if the category exists
        if ($categoryUpdate) {
            // Update the category with the validated data
            $categoryUpdate->update([
                'name' => $request->name,
            ]);

            // Redirect with success message
            return redirect('/admin/display-categories/')->with('update', 'Category Updated Successfully');
        }

        // Optionally handle the case where the category isn't found
        return redirect('/admin/display-categories/')->with('error', 'Category not found');
    }





    public function deleteCategories($id)
    {
        $deleteCategory = Category::find($id);
        $deleteCategory->delete();

        if ($deleteCategory) {


            // Redirect with success message
            return redirect('/admin/display-categories/')->with('delete', 'Category deleted Successfully');
        }
    }


    //jobs
    public function allJobs()
    {
        $jobs = Job::all();


        return view('admins/all-jobs', compact('jobs'));
    }


    public function createJobs()
    {
        $categories = Category::all();


        return view('admins/create-jobs', compact('categories'));
    }

    public function storeJobs(Request $request)
    {
        $request->validate([
            'job_title' => 'required|max:40',
            'job_region' => 'required|max:40',
            'company' => 'required',
            'job_type' => 'required',
            'vacancy' => 'required',
            'experience' => 'required',
            'salary' => 'required',
            'gender' => 'required',
            'application_deadline' => 'required',
            'jobdescription' => 'required',
            'responsibilities' => 'required',
            'education_experience' => 'required',
            'otherbenefits' => 'required',
            'category' => 'required',
            'image' => 'required|image|mimes:jpg,jpeg,png|max:2048',


        ]);



        $destinationPath = 'assets/images/';
        $myimage = $request->image->getClientOriginalName();
        $request->image->move(public_path($destinationPath), $myimage);

        $createJobs = Job::create([
            'job_title' => $request->job_title,
            'job_region' => $request->job_region,
            'company' => $request->company,
            'job_type' => $request->job_type,
            'vacancy' => $request->vacancy,
            'experience' => $request->experience,
            'salary' => $request->salary,
            'gender' => $request->gender,
            'application_deadline' => $request->application_deadline,
            'jobdescription' => $request->jobdescription,
            'responsibilities' => $request->responsibilities,
            'education_experience' => $request->education_experience,
            'otherbenefits' => $request->otherbenefits,
            'category' => $request->category,
            'image' => $myimage,

        ]);

        if ($createJobs) {
            return redirect('admin/display-jobs/')->with('create', 'Job created successfully');
        }else{
            return redirect()->back()->with('error', 'Failed to create job');
        }
    }

    public function deleteJobs($id)
    {
        $deleteJob = Job::find($id);


        if (File::exists(public_path('assets/images/' . $deleteJob->image))) {
            File::delete(public_path('assets/images/' . $deleteJob->image));
        } else {
            dd('File does not exists');
        }
        $deleteJob->delete();


        return redirect('admin/display-jobs/')->with('delete', 'Job deleted successfully');
    }
    //apps



    public function displayApps()
    {
        $apps = Application::all();
        return view('admins.all-apps', compact('apps'));
    }


    public function deleteApps($id)
    {
        $deleteApp = Application::find($id);



        $deleteApp->delete();

        if ($deleteApp)
            return redirect('admin/display-apps/')->with('delete', 'Application deleted successfully');
    }
}
