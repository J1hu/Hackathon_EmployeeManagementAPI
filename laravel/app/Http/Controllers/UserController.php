<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Models\User;

class UserController extends Controller
{
    public function index(Request $request) {
        $users = User::get();

        return response()->json(['employee' => $users], 200);
    }

    public function get(Request $request, $employeeId) {
        $user = User::where('id', $employeeId)->first();
        
        if (!$user) {
            return response()->json(['error' => 'User not found'], 404);
        }
        return response()->json(['employee' => $user], 200);
    }

    public function store(Request $request) {
        $firstName = $request->get('firstName');
        $lastName = $request->get('lastName');
        $position = $request->get('position');
        $sickLeaveCredits = $request->get('sickLeaveCredits');
        $vacationLeaveCredits = $request->get('vacationLeaveCredits');
        $hourlyRate = $request->get('hourlyRate');
        
        if (!$firstName && !$lastName && !$position && !$sickLeaveCredits && !$vacationLeaveCredits && !$hourlyRate) {
            return response()->json(['error'=> 'Please enter all required information!'], 401);
        }

        $userModel = User::where('firstName', $firstName)->where('lastName', $lastName)->first();
        if ($userModel) {
            return response()->json(['error' => 'User already exist!'], 309);
        }

        $newUser = User::create([
            'firstName' => $firstName,
            'lastName' => $lastName,
            'position' => $position,
            'sickLeaveCredits' => $sickLeaveCredits,
            'vacationLeaveCredits' => $vacationLeaveCredits,
            'hourlyRate' => $hourlyRate
        ]);
        return response()->json(['employee' => $newUser]);
    }

    public function update(Request $request, $employeeId) {
        $firstName = $request->get('firstName');
        $lastName = $request->get('lastName');
        $position = $request->get('position');
        $sickLeaveCredits = $request->get('sickLeaveCredits');
        $vacationLeaveCredits = $request->get('vacationLeaveCredits');
        $hourlyRate = $request->get('hourlyRate');

        $userModel = User::where('id', $employeeId)->first();
        if (!$userModel) {
            return response()->json(['error' => 'Cannot find user!'], 404);
        }

        if (!$firstName && !$lastName) {
            return response()->json(['error'=> 'There is no user to edit!'], 401);
        }

        $userAlreadyExist = User::where('firstName', $firstName)->where('id', '!=', $employeeId)->first();
        if ($userAlreadyExist) {
            return response()->json(['error' => 'User already exist!'], 401);
        }

        $userModel->firstName = $firstName;
        $userModel->lastName = $lastName;
        $userModel->position = $position;
        $userModel->sickLeaveCredits = $sickLeaveCredits;
        $userModel->vacationLeaveCredits = $vacationLeaveCredits;
        $userModel->hourlyRate = $hourlyRate;
        $userModel->save();

        return response()->json(['employee' => $userModel], 200);
    }

    public function delete(Request $request, $employeeId) {
        $userModel = User::where('id', $employeeId)->first();

        if(!$userModel) {
            return response()->json(['error' => 'User does not exist!'], 404);
        }

        $userModel->delete();

        return response()->json(['data' => 'success!'], 200);
    }
}
