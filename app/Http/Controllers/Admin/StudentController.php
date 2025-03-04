<?php

namespace App\Http\Controllers\Admin;

use App\Models\Agama;
use App\Models\Major;
use App\Models\Classe;
use App\Models\Student;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Storage;

class StudentController extends Controller
{
    public function index(Request $request)
    {
        $query = Student::with(['major', 'class', 'agama']);

        if ($request->class_id) {
            $query->where('class_id', $request->class_id);
        }

        if ($request->major_id) {
            $query->where('major_id', $request->major_id);
        }

        if ($request->gender) {
            $query->where('gender', $request->gender);
        }

        $students = $query->orderBy('name', 'asc')->get();

        $majors = Major::all();
        $classes = Classe::all();

        return view('pages.students.index', compact('students', 'majors', 'classes'));
    }


    public function create()
    {
        // Ambil data untuk major, class, dan agama
        $majors = Major::all();
        $classes = Classe::all();
        $agamas = Agama::all();

        return view('pages.students.create', compact('majors', 'classes', 'agamas'));
    }

    public function store(Request $request)
    {
        // Validasi input
        $request->validate([
            'nisn' => 'required|unique:students,nisn|numeric',
            'name' => 'required|string|max:100',
            'email' => 'nullable|email',
            'phone' => 'nullable|string',
            'address' => 'nullable|string',
            'major_id' => 'required|exists:majors,id',
            'class_id' => 'required|exists:classes,id',
            'agama_id' => 'required|exists:agamas,id',
            'birth_date' => 'nullable|date',
            'student_photo' => 'nullable|image|mimes:jpeg,png,jpg,gif',
        ]);

        // Simpan data siswa
        $student = new Student();
        $student->nisn = $request->nisn;
        $student->name = $request->name;
        $student->email = $request->email;
        $student->phone = $request->phone;
        $student->address = $request->address;
        $student->major_id = $request->major_id;
        $student->class_id = $request->class_id;
        $student->agama_id = $request->agama_id;
        $student->birth_date = $request->birth_date;

        // Proses upload foto
        if ($request->hasFile('student_photo')) {
            $student->student_photo = $request->file('student_photo')->store('students', 'public');
        }

        $student->save();

        return redirect()->route('students.index')->with('success', 'Data Siswa berhasil ditambahkan');
    }

    public function edit($id)
    {
        // Ambil data siswa
        $student = Student::findOrFail($id);

        // Ambil data untuk major, class, dan agama
        $majors = Major::all();
        $classes = Classe::all();
        $agamas = Agama::all();

        return view('pages.students.edit', compact('student', 'majors', 'classes', 'agamas'));
    }

    public function update(Request $request, $id)
    {
        // Validasi input
        $request->validate([
            'nisn' => 'required|numeric|unique:students,nisn,' . $id,
            'name' => 'required|string|max:100',
            'email' => 'nullable|email',
            'phone' => 'nullable|string',
            'address' => 'nullable|string',
            'major_id' => 'required|exists:majors,id',
            'class_id' => 'required|exists:classes,id',
            'agama_id' => 'required|exists:agamas,id',
            'birth_date' => 'nullable|date',
            'student_photo' => 'nullable|image|mimes:jpeg,png,jpg,gif',
        ]);

        // Update data siswa
        $student = Student::findOrFail($id);
        $student->nisn = $request->nisn;
        $student->name = $request->name;
        $student->email = $request->email;
        $student->phone = $request->phone;
        $student->address = $request->address;
        $student->major_id = $request->major_id;
        $student->class_id = $request->class_id;
        $student->agama_id = $request->agama_id;
        $student->birth_date = $request->birth_date;

        // Proses upload foto jika ada
        if ($request->hasFile('student_photo')) {
            // Hapus foto lama jika ada
            if ($student->student_photo) {
                Storage::delete('public/' . $student->student_photo);
            }
            $student->student_photo = $request->file('student_photo')->store('students', 'public');
        }

        $student->save();

        return redirect()->route('students.index')->with('success', 'Data Siswa berhasil diperbarui');
    }

    public function destroy($id)
    {
        $student = Student::findOrFail($id);

        // Hapus foto jika ada
        if ($student->student_photo) {
            Storage::delete('public/' . $student->student_photo);
        }

        // Hapus data siswa
        $student->delete();

        return redirect()->route('students.index')->with('success', 'Data Siswa berhasil dihapus');
    }
}
