<?php

namespace App\Repository;


use App\Repository\Repository;
use App\User;
use Illuminate\Support\Facades\Gate;

class UsersRepository extends Repository
{
	
    
	public function __construct(User $user) {
		$this->model = $user;
		
	}
	
	public function addUser($request) {
		
		
		/* if (Gate::denies('create',$this->model)) {
            abort(403);
        } */
		
		$data = $request->all();
		//dd($data);
	
		$user = $this->model->create([
            'name' => $data['name'],
            /* 'login' => $data['login'], */
            'email' => $data['email'],
            'password' => bcrypt($data['password']),
        ]);

		if($user) {
			$user->roles()->attach($data['role_id']);
		}
		
		return ['status' => 'Пользователь добавлен'];
		
	}
	
	
	public function updateUser($request, $user) {
		
		
		$data = $request->all();
		//dd($data);
		
		if(isset($data['password'])) {
			$data['password'] = bcrypt($data['password']);
		}
		if(!isset($data['password'])){
			$data['password'] = $user->password;
		}
		
		$user->fill($data)->update();
		$user->roles()->sync([$data['role_id']]);
		
		return ['status' => 'Пользователь изменен'];
		
	}
	
	public function deleteUser($user) {
		
		
		$user->roles()->detach();
		
		if($user->delete()) {
			return ['status' => 'Пользователь удален'];	
		}
	}
	
	

	
}