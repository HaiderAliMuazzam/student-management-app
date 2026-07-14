<h1>Students</h1>

<form method="POST" action="/students">
    @csrf
    <input type="text" name="name" placeholder="Name">
    <input type="text" name="grade" placeholder="Grade">
    <input type="text" name="subject" placeholder="Subject">
    <input type="text" name="contact_number" placeholder="Contact Number">
    <button type="submit">Add Student</button>
</form>

<ul>
    @foreach ($students as $student)
        <li>{{ $student->name }} — {{ $student->grade }} — {{ $student->subject }} — {{ $student->contact_number }}</li>
    @endforeach
</ul>