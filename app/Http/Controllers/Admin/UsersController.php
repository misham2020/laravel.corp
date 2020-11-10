<?php

namespace App\Http\Controllers\Admin;

use App\Http\Requests\UserRequest;
use App\Repository\RolesRepository;
use App\Repository\UsersRepository;
use App\Role;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;

class UsersController extends AdminController
{
    
    protected $us_rep;
    protected $rol_rep;


    public function __construct(RolesRepository $rol_rep, UsersRepository $us_rep) {
        parent::__construct();
        
       

        $this->us_rep = $us_rep;
        $this->rol_rep = $rol_rep;

        $this->template = 'admin.users';
        
    }


    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
        if((new Gate)::denies('admin', new User)) {
			abort(403);
		} 
        $users = $this->us_rep->get();

        $this->content = view('admin.users_content')->with(['users'=>$users ])->render();
        
        return $this->renderOutput();
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
		
		$this->title =  'Новый пользователь';
		
		$roles = $this->getRoles()->reduce(function ($returnRoles, $role) {
		    $returnRoles[$role->id] = $role->name;
		    return $returnRoles;
		}, []);
		
		$this->content = view('admin.users_create_content')->with('roles',$roles)->render();
        
        return $this->renderOutput();
    }
	
	public function getRoles() {
		$roles = $this->rol_rep->get();
        
        return $roles;
	}

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(UserRequest $request)
    {
        //
        //dd($request);
		$result = $this->us_rep->addUser($request);
		if(is_array($result) && !empty($result['error'])) {
			return back()->with($result);
		}
		return redirect('/admin')->with($result);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit(User $user)
    {
       $this->title =  'Редактирование пользователя - '. $user->name;
		
		$roles = $this->getRoles()->reduce(function ($returnRoles, $role) {
		    $returnRoles[$role->id] = $role->name;
		    return $returnRoles;
		}, []);
		
		$this->content = view('admin.users_create_content')->with(['roles'=>$roles,'user'=>$user])->render();
        
        return $this->renderOutput();
		
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(UserRequest $request, User $user)
    {
        //
		$result = $this->us_rep->updateUser($request,$user);
		if(is_array($result) && !empty($result['error'])) {
			return back()->with($result);
		}
		return redirect('/admin')->with($result);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
     public function destroy(User $user)
    {
        $result = $this->us_rep->deleteUser($user);
		if(is_array($result) && !empty($result['error'])) {
			return back()->with($result);
		}
		return redirect('/admin')->with($result);
    }
}
