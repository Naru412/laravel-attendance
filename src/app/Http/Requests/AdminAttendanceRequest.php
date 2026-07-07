<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class AdminAttendanceRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'clock_in' => ['required'],
            'clock_out' => ['required', 'after:clock_in'],

            'break_starts' => ['nullable', 'array'],
            'break_ends' => ['nullable', 'array'],

            'break_starts.*' => ['nullable'],
            'break_ends.*' => ['nullable'],

            'remark' => ['required'],
        ];
    }

    public function messages()
    {
        return [
            'clock_in.required' => '出勤時間を入力してください',
            'clock_out.required' => '退勤時間を入力してください',
            'clock_out.after' => '出勤時間もしくは退勤時間が不適切な値です',

            'break_starts.required' => '休憩開始時間を入力してください',
            'break_ends.required' => '休憩終了時間を入力してください',

            'break_starts.*.required' => '休憩開始時間を入力してください',
            'break_ends.*.required' => '休憩終了時間を入力してください',

            'remark.required' => '備考を記入してください',
        ];
    }

    public function withValidator($validator)
    {
        $validator->after(function ($validator) {
            $clock_In = $this->input('clock_in');
            $clockOut = $this->input('clock_out');
            $breakStarts = $this->input('break_starts', []);
            $breakEnds = $this->input('break_ends', []);

            foreach ($breakStarts as $index => $breakStart) {
                $breakEnd = $breakEnds[$index] ?? null;

                //休憩開始時間が勤務時間外
                if ($breakStart) {
                    if ($breakStart < $clock_In || $breakStart > $clockOut ) {
                        $validator->errors()->add(
                            'break_starts.' . $index,
                            '休憩時間が不適切な値です'
                        );
                    }
                }

                    //休憩終了時間が退勤時間よりあと
                if ($breakEnd) {
                    if ($breakEnd > $clockOut) {
                        $validator->errors()->add(
                            'break_ends.' . $index,
                            '休憩時間もしくは退勤時間が不適切な値です'
                        );
                    }
                }
            } 
        });
    }
}

