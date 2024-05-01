<x-layout>
	<form method="POST" action="/students/{{$student->id}}" enctype="multipart/form-data">
		@csrf
		@method('PUT')
		<div class="mb-6">
			<label for="id" class="block mb-2 uppercase font-bold text-xs text-gray-700">
				Student ID
			</label>
			<input type="text" class="border border-gray-400 p-2 w-full" name="id" id="id" value="{{$student->id}}" required>
			
			@error('id')
					<p class="text-red-500 text-xs mt-1">{{ $message }}</p>
			@enderror
		</div>

		<div class="mb-6">
			<label for="name" class="block mb-2 uppercase font-bold text-xs text-gray-700">
				Name
			</label>
			<input type="text" class="border border-gray-400 p-2 w-full" name="name" id="name" value="{{$student->name}}" required>

			@error('name')
					<p class="text-red-500 text-xs mt-1">{{ $message }}</p>
			@enderror
		</div>

		<div class="mb-6">
			<label for="email" class="block mb-2 uppercase font-bold text-xs text-gray-700">
				Email
			</label>
			<input type="email" class="border border-gray-400 p-2 w-full" name="email" id="email" value="{{$student->email}}" required>

			@error('email')
					<p class="text-red-500 text-xs mt-1">{{ $message }}</p>
			@enderror
		</div>

		<div class="mb-6">
			<label for="faculty" class="block mb-2 uppercase font-bold text-xs text-gray-700">
				Faculty
			</label>
			<input type="faculty" class="border border-gray-400 p-2 w-full" name="faculty" id="faculty" value="{{$student->faculty}}" required>

			@error('faculty')
					<p class="text-red-500 text-xs mt-1">{{ $message }}</p>
			@enderror
		</div>

		<div class="mb-6">
			<label for="program" class="block mb-2 uppercase font-bold text-xs text-gray-700">
				Program
			</label>
			<input type="program" class="border border-gray-400 p-2 w-full" name="program" id="program" value="{{$student->program}}" required>

			@error('program')
					<p class="text-red-500 text-xs mt-1">{{ $message }}</p>
			@enderror
		</div>

		<div class="mb-6">
			<label for="photo" class="block mb-2 uppercase font-blod tex-xs text-gray-700">
				Student Photo
			</label>
			<input type="file" name="photo">

			@error('photo')
					<p class="text-red-500 text-xs mt-1">{{ $message }}</p>
			@enderror
		</div>

		{{-- <div class="mb-6">
			<label for="password" class="block mb-2 uppercase font-bold text-xs text-gray-700">
				Password
			</label>
			<input type="password" class="border border-gray-400 p-2 w-full" name="password" id="password" value="{{old('password')}}" required>

			@error('password')
					<p class="text-red-500 text-xs mt-1">{{ $message }}</p>
			@enderror
		</div>

		<div class="mb-6">
			<label for="password_confirmation" class="block mb-2 uppercase font-bold text-xs text-gray-700">
				Confirm Password
			</label>
			<input type="password" class="border border-gray-400 p-2 w-full" name="password_confirmation" id="password_confirmation" value="{{old('password-confirmation')}}" required>

			@error('password-confirmation')
					<p class="text-red-500 text-xs mt-1">{{ $message }}</p>
			@enderror
		</div> --}}

		<button type="submit" class="bg-blue-400 text-white rounded py-2 px-4 hover:bg-blue-500">
			Edit
		</button>
		
	</form>
</x-layout>