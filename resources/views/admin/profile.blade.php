@extends('admin.layout')
@section('title', 'Profile & About')
@section('content')
<div class="page-head"><div><h2>Profile & About</h2><p class="muted">This content is shared by the desktop, About window, resume, and contact window.</p></div></div>
<form class="card" method="POST" action="{{ route('admin.profile.update') }}" enctype="multipart/form-data">@csrf @method('PUT')
    <div class="form-grid">
        <label>Name<input name="name" value="{{ old('name', $profile->name) }}" required></label>
        <label>Professional title<input name="title" value="{{ old('title', $profile->title) }}" required></label>
        <label>Location<input name="location" value="{{ old('location', $profile->location) }}"></label>
        <label>Email<input type="email" name="email" value="{{ old('email', $profile->email) }}" required></label>
        <label>Phone<input name="phone" value="{{ old('phone', $profile->phone) }}"></label>
        <label>Website URL<input type="url" name="website" value="{{ old('website', $profile->website) }}"></label>
        <label>Upwork URL<input type="url" name="upwork_url" value="{{ old('upwork_url', $profile->upwork_url) }}"></label>
        <label>Availability text<input name="availability" value="{{ old('availability', $profile->availability) }}"></label>
        <label>Years in web development<input type="number" name="years_experience" value="{{ old('years_experience', $profile->years_experience) }}" required></label>
        <label>Years full stack<input type="number" name="full_stack_years" value="{{ old('full_stack_years', $profile->full_stack_years) }}" required></label>
        <label class="wide">Resume profile summary<textarea name="intro">{{ old('intro', $profile->intro) }}</textarea></label>
        <label class="wide">About paragraph 1<textarea name="bio" required>{{ old('bio', $profile->bio) }}</textarea></label>
        <label class="wide">About paragraph 2<textarea name="secondary_bio">{{ old('secondary_bio', $profile->secondary_bio) }}</textarea></label>
        <label class="wide">Languages<input name="languages" value="{{ old('languages', $profile->languages) }}"></label>
        <label>Profile image<input type="file" name="profile_image_upload" accept="image/*"><span class="muted">Leave empty to keep the current image.</span></label>
        <div><img class="preview" src="{{ $profile->profile_image_url }}" alt=""></div>
    </div>
    <div class="form-actions"><button class="btn" type="submit">Save profile</button></div>
</form>
@endsection
