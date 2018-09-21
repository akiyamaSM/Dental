<?php

namespace App\Jobs;

use Illuminate\Contracts\Bus\SelfHandling;
use App\Patient;


class CreatePatient extends Job implements SelfHandling
{
    protected $firstName;
    protected $lastName;
    protected $CIN;
    protected $gender;
    protected $birthDay;
    protected $phone;

    /**
     * Create a new CreatePatient job instance.
     * @param $request
     * @internal param $firstName
     * @internal param $lastName
     * @internal param $CIN
     * @internal param $gender
     * @internal param $birthDay
     * @internal param $phone
     */
    public function __construct($request)
    {
        $this->firstName = $request->firstName;
        $this->lastName = $request->lastName;
        $this->CIN = $request->CIN;
        $this->gender = $request->gender;
        $this->birthDay = $request->birthDay;
        $this->phone = $request->phone;
    }

    /**
     * Execute the job.
     *
     * @return Patient
     */
    public function handle()
    {
        $patient = Patient::create([
            'firstName' => $this->firstName,
            'lastName' => $this->lastName,
            'CIN' => $this->CIN,
            'birthDay' => $this->birthDay,
            'phone' => $this->phone,
            'gender' => $this->gender,
        ]);

        return $patient;
    }
}
