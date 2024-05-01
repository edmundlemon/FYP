<x-layout>
	<form method="POST" action="/register/lecturer" enctype="multipart/form-data">
		@csrf
		<div class="mb-3">
			<label for="id" class="form-label">Lecturer ID</label>
			<input type="text" class="form-control border border-gray-400 p-2" id="id" name="id" value="{{old('id')}}" required>
			@error('id')
				<div class="text-red-500 text-xs mt-1">{{ $message }}</div>
			@enderror
		</div>
		<div class="mb-3">
			<label for="name" class="form-label">Lecturer's Name</label>
			<input type="text" class="form-control border border-gray-400 p-2" id="name" name="name" value="{{old('name')}}" required>
			@error('name')
				<div class="text-red-500 text-xs mt-1">{{ $message }}</div>
			@enderror
		</div>
		<div class="mb-3">
			<label for="email" class="form-label">Lecturer Email</label>
			<input type="email" class="form-control border border-gray-400 p-2" id="email" name="email" value="{{old('email')}}" required>
			@error('email')
				<div class="text-red-500 text-xs mt-1">{{ $message }}</div>
			@enderror
		</div>
		<div class="mb-3">
			<label for="password" class="form-label">Password</label>
			<input type="password" class="form-control border border-gray-400 p-2" id="password" name="password" value="{{old('password')}}" required>
			@error('password')
				<div class="text-red-500 text-xs mt-1">{{ $message }}</div>
			@enderror
		</div>
		<div class="mb-3">
			<label for="password_confirmation" class="form-label">Confirm Password</label>
			<input type="password" class="form-control border border-gray-400 p-2" id="password_confirmation" name="password_confirmation" value="{{old('password_confirmation')}}" required>
			@error('password_confirmation')
				<div class="text-red-500 text-xs mt-1">{{ $message }}</div>
			@enderror
		</div>
		<div class="mb-3">
			<label for="faculty" class="form-label">Faculty</label>
			<input type="text" class="form-control border border-gray-400 p-2" id="faculty" name="faculty" value="{{old('faculty')}}" required>
			@error('faculty')
				<div class="text-red-500 text-xs mt-1">{{ $message }}</div>
			@enderror
		</div>
		<div class="mb-3">
			<label for="office" class="form-label">Office</label>
			<input type="text" class="form-control border border-gray-400 p-2" id="office" name="office" value="{{old('office')}}" required>
			@error('office')
				<div class="text-red-500 text-xs mt-1">{{ $message }}</div>
			@enderror
		</div>
		<div class="mb-3">
			<label for="photo" class="form-label">Lecturer's Photo</label>
			<input type="file" class="form-control border border-gray-400 p-2" id="photo" name="photo" value="{{old('photo')}}" required>
		</div>
		<button type="submit" class="bg-blue-400 text-white rounded py-2 px-4 hover:bg-blue-500">Register</button>
</x-layout>