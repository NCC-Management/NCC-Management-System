@extends('layouts.cadet-new')
@section('title', 'My Profile')
@section('page-title', 'My Profile')

@push('styles')
<link href="https://cdnjs.cloudflare.com/ajax/libs/cropperjs/1.5.13/cropper.min.css" rel="stylesheet">
<style>
    .cropper-view-box,
    .cropper-face {
      border-radius: 50%;
    }
</style>
@endpush

@section('content')

<div class="max-w-7xl mx-auto">

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">

        {{-- Left Column: Profile Card --}}
        <div class="lg:col-span-1 space-y-8">
            <div class="bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden relative transition-all duration-300 hover:shadow-xl hover:-translate-y-1">
                <!-- Background Banner -->
                <div class="h-32 bg-gradient-to-br from-blue-700 to-indigo-900 relative">
                    <svg class="absolute inset-0 w-full h-full text-white/10" fill="currentColor" viewBox="0 0 100 100" preserveAspectRatio="none">
                        <polygon points="0,100 100,0 100,100" />
                    </svg>
                </div>
                
                <!-- Avatar & Status -->
                <div class="px-8 pb-8 text-center relative -mt-16">
                    <div class="w-32 h-32 rounded-3xl bg-white p-2 mx-auto mb-4 shadow-xl border border-gray-100 ring-4 ring-white transition-transform hover:scale-105 duration-300">
                        @if(auth()->user()->profile_photo)
                            <img src="{{ asset('storage/' . auth()->user()->profile_photo) }}" alt="Profile Photo" class="w-full h-full rounded-2xl object-cover shadow-sm">
                        @else
                            <div class="w-full h-full rounded-2xl bg-gradient-to-br from-blue-600 to-indigo-700 flex items-center justify-center text-white text-4xl font-extrabold shadow-inner border border-white/20">
                                {{ auth()->user()->initials() }}
                            </div>
                        @endif
                    </div>
                    
                    <h2 class="text-2xl font-bold text-gray-800 tracking-tight">{{ auth()->user()->name }}</h2>
                    <p class="text-sm font-bold text-gray-400 mt-1 mb-5 tracking-wide">{{ $cadet->enrollment_no }}</p>
                    
                    <span class="inline-flex items-center gap-2 bg-green-50 text-green-700 px-4 py-2 rounded-xl text-xs font-bold border border-green-200 shadow-sm mx-auto">
                        <span class="w-2 h-2 rounded-full bg-green-500 animate-pulse"></span> Approved Cadet
                    </span>
                </div>

                <!-- Info List -->
                <div class="border-t border-gray-100 p-8 bg-gray-50/30">
                    <h3 class="text-xs font-bold text-gray-400 uppercase tracking-widest mb-6">Cadet Information</h3>
                    <ul class="space-y-4 text-sm">
                        @foreach([
                            ['icon' => 'fa-ranking-star', 'label' => 'Rank', 'value' => $cadet->rank ?? '—'],
                            ['icon' => 'fa-shield-halved', 'label' => 'Unit', 'value' => $cadet->unit?->unit_name ?? 'Not Assigned'],
                            ['icon' => 'fa-envelope', 'label' => 'Email', 'value' => auth()->user()->email],
                            ['icon' => 'fa-phone', 'label' => 'Phone', 'value' => $cadet->phone ?? '—'],
                            ['icon' => 'fa-calendar', 'label' => 'DOB', 'value' => $cadet->dob?->format('d M Y') ?? '—'],
                            ['icon' => 'fa-venus-mars', 'label' => 'Gender', 'value' => ucfirst($cadet->gender ?? '—')],
                            ['icon' => 'fa-graduation-cap', 'label' => 'Course', 'value' => $cadet->course ?? '—'],
                            ['icon' => 'fa-id-card', 'label' => 'Student ID', 'value' => $cadet->student_id ?? '—'],
                        ] as $item)
                        <li class="flex items-center justify-between pb-4 border-b border-gray-100/60 last:border-0 last:pb-0 group">
                            <span class="text-gray-500 font-medium flex items-center gap-3">
                                <div class="w-8 h-8 rounded-lg bg-white border border-gray-100 flex items-center justify-center text-gray-400 shadow-sm group-hover:text-blue-500 transition-colors">
                                    <i class="fa-solid {{ $item['icon'] }} text-xs"></i>
                                </div>
                                {{ $item['label'] }}
                            </span>
                            <span class="font-bold text-gray-800 text-right group-hover:text-blue-700 transition-colors">{{ $item['value'] }}</span>
                        </li>
                        @endforeach
                    </ul>
                </div>
            </div>
        </div>

        {{-- Right Column: Edit Form --}}
        <div class="lg:col-span-2 space-y-8">
            <div class="bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden transition-all duration-300 hover:shadow-xl hover:-translate-y-1">
                <div class="px-8 py-6 border-b border-gray-100 bg-gray-50/50 flex items-center gap-4">
                    <div class="w-12 h-12 rounded-xl bg-blue-50 text-blue-600 flex items-center justify-center shadow-inner">
                        <i class="fa-solid fa-user-pen text-xl"></i>
                    </div>
                    <div>
                        <h3 class="font-bold text-gray-800 text-xl">Edit Profile</h3>
                        <p class="text-sm text-gray-500 font-medium">Update your personal contact details and records</p>
                    </div>
                </div>

                <div class="p-8">
                    @if($errors->any())
                    <div class="mb-8 bg-red-50 text-red-700 p-5 rounded-xl flex items-start gap-4 border border-red-200 text-sm shadow-sm font-medium">
                        <i class="fa-solid fa-circle-exclamation mt-0.5 text-lg"></i>
                        <span>{{ $errors->first() }}</span>
                    </div>
                    @endif

                    <form method="POST" action="{{ route('cadet.profile.update') }}" enctype="multipart/form-data" class="space-y-8">
                        @csrf @method('PUT')

                        <!-- Profile Photo Upload Section -->
                        <div class="flex flex-col sm:flex-row items-center gap-6 pb-6 border-b border-gray-100">
                            <div class="relative w-24 h-24 rounded-full border-4 border-white shadow-md bg-gray-50 flex-shrink-0 flex items-center justify-center overflow-hidden">
                                @if(auth()->user()->profile_photo)
                                    <img id="avatar-preview" src="{{ asset('storage/' . auth()->user()->profile_photo) }}" alt="Profile Photo" class="w-full h-full object-cover">
                                @else
                                    <img id="avatar-preview" src="" alt="Profile Photo" class="w-full h-full object-cover hidden">
                                    <div id="avatar-initials" class="w-full h-full bg-gradient-to-br from-blue-500 to-blue-600 flex items-center justify-center text-white text-3xl font-extrabold shadow-inner">
                                        {{ strtoupper(substr(auth()->user()->name, 0, 1)) }}
                                    </div>
                                @endif
                            </div>
                            <div class="flex-1 w-full text-center sm:text-left">
                                <label class="block text-sm font-bold text-gray-800 mb-2">Update Profile Photo</label>
                                <input type="hidden" name="profile_photo_base64" id="profile_photo_base64">
                                <input type="file" id="profile_photo_input" accept="image/png, image/jpeg, image/jpg" class="block w-full text-sm text-gray-500 file:mr-4 file:py-2.5 file:px-5 file:rounded-xl file:border-0 file:text-sm file:font-bold file:bg-blue-50 file:text-blue-700 hover:file:bg-blue-100 transition-colors cursor-pointer">
                                <p class="mt-2 text-xs text-gray-400 font-medium">Valid formats: JPG, JPEG, PNG. Max size: 2MB.</p>
                            </div>
                        </div>

                        <!-- Cropper Modal -->
                        <div id="cropperModal" class="fixed inset-0 z-[999] bg-black/60 hidden items-center justify-center p-4">
                            <div class="bg-white rounded-2xl shadow-2xl max-w-lg w-full overflow-hidden flex flex-col">
                                <div class="p-4 border-b border-gray-100 flex justify-between items-center bg-gray-50">
                                    <h3 class="font-bold text-gray-800">Crop Profile Photo</h3>
                                    <button type="button" onclick="closeCropper()" class="text-gray-400 hover:text-red-500 transition-colors">
                                        <i class="fa-solid fa-xmark text-xl"></i>
                                    </button>
                                </div>
                                <div class="p-4 h-80 bg-gray-900 w-full flex items-center justify-center">
                                    <img id="image-to-crop" class="max-w-full max-h-full block" src="">
                                </div>
                                <div class="p-4 border-t border-gray-100 flex justify-end gap-3 bg-gray-50">
                                    <button type="button" onclick="closeCropper()" class="px-5 py-2 rounded-xl text-gray-600 font-bold hover:bg-gray-200 transition-colors">Cancel</button>
                                    <button type="button" onclick="applyCrop()" class="px-5 py-2 rounded-xl bg-blue-600 text-white font-bold hover:bg-blue-700 shadow-md transition-colors">Apply Crop</button>
                                </div>
                            </div>
                        </div>

                        <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
                            <div class="space-y-2">
                                <label class="text-xs font-bold text-gray-500 uppercase tracking-widest block">Full Name</label>
                                <input type="text" name="name" class="w-full bg-gray-50 border border-gray-200 text-gray-900 text-sm font-bold rounded-xl focus:ring-blue-500 focus:border-blue-500 block p-3.5 transition-colors duration-200 shadow-sm" value="{{ old('name', auth()->user()->name) }}" required>
                            </div>

                            <div class="space-y-2">
                                <label class="text-xs font-bold text-gray-500 uppercase tracking-widest block">Phone Number</label>
                                <input type="text" name="phone" class="w-full bg-gray-50 border border-gray-200 text-gray-900 text-sm font-bold rounded-xl focus:ring-blue-500 focus:border-blue-500 block p-3.5 transition-colors duration-200 shadow-sm" value="{{ old('phone', $cadet->phone) }}" placeholder="+91 XXXXX XXXXX">
                            </div>

                            <div class="space-y-2">
                                <label class="text-xs font-bold text-gray-500 uppercase tracking-widest block">Date of Birth</label>
                                <input type="date" name="dob" class="w-full bg-gray-50 border border-gray-200 text-gray-900 text-sm font-bold rounded-xl focus:ring-blue-500 focus:border-blue-500 block p-3.5 transition-colors duration-200 shadow-sm" value="{{ old('dob', $cadet->dob?->format('Y-m-d')) }}">
                            </div>

                            <div class="space-y-2">
                                <label class="text-xs font-bold text-gray-500 uppercase tracking-widest block">Gender</label>
                                <select name="gender" class="w-full bg-gray-50 border border-gray-200 text-gray-900 text-sm font-bold rounded-xl focus:ring-blue-500 focus:border-blue-500 block p-3.5 transition-colors duration-200 appearance-none shadow-sm">
                                    <option value="">Select Gender</option>
                                    @foreach(['male','female','other'] as $g)
                                    <option value="{{ $g }}" {{ old('gender', $cadet->gender) === $g ? 'selected' : '' }}>{{ ucfirst($g) }}</option>
                                    @endforeach
                                </select>
                            </div>

                            <div class="space-y-2">
                                <label class="text-xs font-bold text-gray-500 uppercase tracking-widest block">Course</label>
                                <input type="text" name="course" class="w-full bg-gray-50 border border-gray-200 text-gray-900 text-sm font-bold rounded-xl focus:ring-blue-500 focus:border-blue-500 block p-3.5 transition-colors duration-200 shadow-sm" value="{{ old('course', $cadet->course) }}" placeholder="B.Tech, B.Sc, etc.">
                            </div>

                            <div class="space-y-2">
                                <label class="text-xs font-bold text-gray-500 uppercase tracking-widest block">Student ID</label>
                                <input type="text" name="student_id" class="w-full bg-gray-50 border border-gray-200 text-gray-900 text-sm font-bold rounded-xl focus:ring-blue-500 focus:border-blue-500 block p-3.5 transition-colors duration-200 shadow-sm" value="{{ old('student_id', $cadet->student_id) }}">
                            </div>
                        </div>

                        <div class="space-y-2 mt-4">
                            <label class="text-xs font-bold text-gray-500 uppercase tracking-widest block">Full Address</label>
                            <textarea name="address" rows="3" class="w-full bg-gray-50 border border-gray-200 text-gray-900 text-sm font-medium rounded-xl focus:ring-blue-500 focus:border-blue-500 block p-4 transition-colors duration-200 resize-y shadow-sm" placeholder="Your permanent address...">{{ old('address', $cadet->address) }}</textarea>
                        </div>

                        <div class="pt-6 border-t border-gray-100 flex justify-end">
                            <button type="submit" class="text-white bg-blue-600 hover:bg-blue-700 focus:ring-4 focus:outline-none focus:ring-blue-300 font-bold rounded-xl text-sm px-8 py-3.5 text-center flex items-center gap-3 transition-colors shadow-lg shadow-blue-500/30">
                                <i class="fa-solid fa-floppy-disk"></i> Save Changes
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>

    </div>

</div>

@push('scripts')
<script src="https://cdnjs.cloudflare.com/ajax/libs/cropperjs/1.5.13/cropper.min.js"></script>
<script>
    let cropper = null;
    const profileInput = document.getElementById('profile_photo_input');
    const cropperModal = document.getElementById('cropperModal');
    const imageToCrop = document.getElementById('image-to-crop');
    const avatarPreview = document.getElementById('avatar-preview');
    const avatarInitials = document.getElementById('avatar-initials');
    const base64Input = document.getElementById('profile_photo_base64');

    if(profileInput) {
        profileInput.addEventListener('change', function (e) {
            const files = e.target.files;
            if (files && files.length > 0) {
                const file = files[0];
                
                // Validate file type
                if (!file.type.match('image/jpeg') && !file.type.match('image/png') && !file.type.match('image/jpg')) {
                    alert('Invalid file format. Only JPG, JPEG, and PNG are allowed.');
                    profileInput.value = '';
                    return;
                }

                // Validate file size (2MB max)
                if (file.size > 2 * 1024 * 1024) {
                    alert('File is too large. Maximum size is 2MB.');
                    profileInput.value = '';
                    return;
                }

                const reader = new FileReader();
                reader.onload = function (event) {
                    imageToCrop.src = event.target.result;
                    cropperModal.classList.remove('hidden');
                    cropperModal.classList.add('flex');
                    
                    if (cropper) {
                        cropper.destroy();
                    }
                    
                    cropper = new Cropper(imageToCrop, {
                        aspectRatio: 1,
                        viewMode: 1,
                        autoCropArea: 1,
                        background: false,
                        zoomable: true,
                        scalable: false,
                    });
                };
                reader.readAsDataURL(file);
            }
        });
    }

    function closeCropper() {
        cropperModal.classList.add('hidden');
        cropperModal.classList.remove('flex');
        profileInput.value = ''; 
        if (cropper) {
            cropper.destroy();
            cropper = null;
        }
    }

    function applyCrop() {
        if (!cropper) return;
        
        // Get the cropped canvas
        const canvas = cropper.getCroppedCanvas({
            width: 300,
            height: 300,
            fillColor: '#fff',
            imageSmoothingEnabled: true,
            imageSmoothingQuality: 'high',
        });
        
        // Compress and get Data URL
        const base64Image = canvas.toDataURL('image/jpeg', 0.85); 
        
        // Set values
        base64Input.value = base64Image;
        if(avatarPreview) {
            avatarPreview.src = base64Image;
            avatarPreview.classList.remove('hidden');
        }
        if(avatarInitials) {
            avatarInitials.classList.add('hidden');
        }
        
        closeCropper();
    }
</script>
@endpush

@endsection
