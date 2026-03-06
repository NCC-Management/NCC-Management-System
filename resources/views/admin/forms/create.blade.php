@extends('layouts.admin')

@section('content')

<style>
/* ════════════════════════════════════════════
   NCC ADMISSION FORM - Multi-Step Form
════════════════════════════════════════════ */

.forms-create-page {
    font-family: 'Plus Jakarta Sans', -apple-system, BlinkMacSystemFont, 'Segoe UI', sans-serif;
    background: var(--bg);
    min-height: 100vh;
    color: var(--tx1);
    padding: 2rem 1rem;
    transition: background 0.3s, color 0.3s;
}

/* Progress Bar */
.progress-container {
    width: 100%;
    height: 4px;
    background: var(--bdr);
    border-radius: 2px;
    margin-bottom: 2rem;
    overflow: hidden;
    max-width: 900px;
    margin-left: auto;
    margin-right: auto;
}

.progress-bar {
    height: 100%;
    background: linear-gradient(90deg, #0CC9E8, #1FD57A);
    transition: width 0.3s ease;
    width: 20%;
}

/* Page Header */
.page-header {
    text-align: center;
    margin-bottom: 2rem;
    max-width: 900px;
    margin-left: auto;
    margin-right: auto;
}

.page-header h1 {
    font-size: 1.8rem;
    font-weight: 700;
    color: var(--tx1);
    margin: 0 0 0.5rem 0;
    letter-spacing: -0.03em;
}

.page-header p {
    font-size: 0.9rem;
    color: var(--tx2);
    margin: 0;
}

/* Step Indicator */
.step-indicator {
    display: flex;
    justify-content: space-between;
    align-items: center;
    margin-bottom: 3rem;
    gap: 0.5rem;
    max-width: 900px;
    margin-left: auto;
    margin-right: auto;
}

.step {
    display: flex;
    flex-direction: column;
    align-items: center;
    gap: 0.5rem;
    flex: 1;
}

.step-number {
    width: 40px;
    height: 40px;
    border-radius: 50%;
    background: var(--surf);
    border: 2px solid var(--bdr);
    display: flex;
    align-items: center;
    justify-content: center;
    font-weight: 700;
    font-size: 0.9rem;
    color: var(--tx2);
    transition: all 0.3s;
}

.step.active .step-number {
    background: linear-gradient(135deg, #0CC9E8, #06B6D4);
    border-color: #0CC9E8;
    color: white;
    box-shadow: 0 0 16px rgba(12, 201, 232, 0.3);
    transform: scale(1.1);
}

.step.completed .step-number {
    background: rgba(31, 213, 122, 0.2);
    border-color: #1FD57A;
    color: #1FD57A;
}

.step-label {
    font-size: 0.75rem;
    font-weight: 600;
    color: var(--tx2);
    text-align: center;
    line-height: 1.2;
}

.step.active .step-label {
    color: var(--cyan, #0CC9E8);
    font-weight: 700;
}

.step.completed .step-label {
    color: #1FD57A;
}

.step-line {
    flex: 1;
    height: 2px;
    background: var(--bdr);
    margin: 0 0.5rem;
    margin-top: 20px;
}

.step-line.completed {
    background: linear-gradient(90deg, #0CC9E8, #1FD57A);
}

/* Form Container */
.form-container {
    max-width: 900px;
    margin: 0 auto;
}

.form-card {
    background: var(--bg-card);
    border: 1px solid var(--bdr);
    border-radius: 16px;
    padding: 2.5rem;
    box-shadow: var(--shadow);
    transition: all 0.3s;
    min-height: 500px;
    display: flex;
    flex-direction: column;
}

.form-card:hover {
    border-color: var(--bdr-hi, var(--bdr));
    box-shadow: 0 8px 24px rgba(12, 201, 232, 0.1);
}

/* Form Content */
.form-content {
    flex: 1;
}

.form-step {
    display: none;
    animation: slideIn 0.4s ease;
}

.form-step.active {
    display: block;
}

@keyframes slideIn {
    from {
        opacity: 0;
        transform: translateY(10px);
    }
    to {
        opacity: 1;
        transform: translateY(0);
    }
}

/* Step Title */
.step-title {
    font-size: 1.4rem;
    font-weight: 700;
    color: var(--tx1);
    margin-bottom: 0.5rem;
    display: flex;
    align-items: center;
    gap: 0.8rem;
}

.step-title svg {
    width: 28px;
    height: 28px;
    color: var(--cyan, #0CC9E8);
    flex-shrink: 0;
}

.step-desc {
    font-size: 0.9rem;
    color: var(--tx2);
    margin-bottom: 2rem;
    line-height: 1.5;
}

/* Form Groups */
.form-group {
    display: grid;
    grid-template-columns: 1fr 1fr;
    gap: 1.5rem;
    margin-bottom: 1.5rem;
}

.form-group.full {
    grid-template-columns: 1fr;
}

/* Form Fields */
.form-field {
    display: flex;
    flex-direction: column;
}

.form-field label {
    font-size: 0.85rem;
    font-weight: 600;
    color: var(--tx1);
    margin-bottom: 0.5rem;
    display: flex;
    align-items: center;
    gap: 0.4rem;
}

.form-field label .required {
    color: #F03F5E;
    font-weight: 700;
}

.form-field input,
.form-field select,
.form-field textarea {
    padding: 0.8rem 1rem;
    border: 1px solid var(--bdr);
    border-radius: 10px;
    background: var(--bg);
    color: var(--tx1);
    font-family: inherit;
    font-size: 0.9rem;
    transition: all 0.2s;
}

.form-field input:focus,
.form-field select:focus,
.form-field textarea:focus {
    outline: none;
    border-color: var(--cyan, #0CC9E8);
    box-shadow: 0 0 0 3px rgba(12, 201, 232, 0.1);
    background: var(--bg);
}

.form-field input::placeholder {
    color: var(--tx3);
}

.form-field textarea {
    resize: vertical;
    min-height: 100px;
}

.field-hint {
    font-size: 0.75rem;
    color: var(--tx3);
    margin-top: 0.4rem;
}

/* File Upload Area */
.file-upload-area {
    display: flex;
    flex-direction: column;
    align-items: center;
    justify-content: center;
    padding: 2rem;
    border: 2px dashed var(--bdr);
    border-radius: 12px;
    background: rgba(12, 201, 232, 0.02);
    cursor: pointer;
    transition: all 0.2s;
    gap: 0.8rem;
}

.file-upload-area:hover {
    border-color: var(--cyan, #0CC9E8);
    background: rgba(12, 201, 232, 0.08);
}

.file-upload-area svg {
    width: 36px;
    height: 36px;
    color: var(--cyan, #0CC9E8);
    flex-shrink: 0;
}

.file-upload-area p {
    font-size: 0.95rem;
    font-weight: 600;
    color: var(--tx1);
    margin: 0;
}

.file-hint {
    font-size: 0.75rem;
    color: var(--tx3);
}

.file-name {
    font-size: 0.8rem;
    color: #1FD57A;
    margin-top: 0.5rem;
    display: flex;
    align-items: center;
    gap: 0.3rem;
}

/* Error Styles */
.form-field.error input,
.form-field.error select {
    border-color: #F03F5E;
    box-shadow: 0 0 0 3px rgba(240, 63, 94, 0.1);
}

.error-message {
    font-size: 0.75rem;
    color: #F03F5E;
    margin-top: 0.4rem;
    display: flex;
    align-items: center;
    gap: 0.3rem;
}

/* Info Section */
.info-section {
    background: rgba(12, 201, 232, 0.08);
    border: 1px solid rgba(12, 201, 232, 0.2);
    border-radius: 10px;
    padding: 1rem;
    margin-bottom: 2rem;
    display: flex;
    gap: 0.8rem;
    font-size: 0.85rem;
    color: var(--tx2);
}

.info-section svg {
    width: 18px;
    height: 18px;
    color: var(--cyan, #0CC9E8);
    flex-shrink: 0;
    margin-top: 2px;
}

/* Buttons */
.btn {
    display: inline-flex;
    align-items: center;
    justify-content: center;
    gap: 0.6rem;
    padding: 0.8rem 1.6rem;
    border-radius: 10px;
    font-family: inherit;
    font-size: 0.9rem;
    font-weight: 600;
    cursor: pointer;
    transition: all 0.2s;
    border: none;
    text-decoration: none;
    white-space: nowrap;
}

.btn-primary {
    background: linear-gradient(135deg, #0CC9E8, #06B6D4);
    border: 1px solid rgba(12, 201, 232, 0.4);
    color: white;
    box-shadow: 0 4px 12px rgba(12, 201, 232, 0.25);
    flex: 1;
}

.btn-primary:hover:not(:disabled) {
    box-shadow: 0 6px 16px rgba(12, 201, 232, 0.35);
    transform: translateY(-2px);
}

.btn-secondary {
    background: var(--surf);
    border: 1px solid var(--bdr);
    color: var(--tx2);
    flex: 1;
}

.btn-secondary:hover:not(:disabled) {
    background: var(--surf-hov);
    color: var(--tx1);
}

.btn:disabled {
    opacity: 0.5;
    cursor: not-allowed;
}

.btn svg {
    width: 18px;
    height: 18px;
}

/* Form Actions */
.form-actions {
    display: flex;
    align-items: center;
    justify-content: space-between;
    gap: 1rem;
    margin-top: 2.5rem;
    padding-top: 2rem;
    border-top: 1px solid var(--bdr);
}

/* Checkbox Labels */
.checkbox-label {
    display: flex;
    align-items: flex-start;
    gap: 0.8rem;
    font-size: 0.9rem;
    font-weight: 500;
    background: rgba(12, 201, 232, 0.04);
    padding: 1rem;
    border: 1px solid rgba(12, 201, 232, 0.2);
    border-radius: 10px;
    cursor: pointer;
    margin-bottom: 1rem;
}

.checkbox-label input {
    margin-top: 2px;
    flex-shrink: 0;
    width: 18px;
    height: 18px;
    cursor: pointer;
    accent-color: var(--cyan, #0CC9E8);
}

/* Responsive */
@media (max-width: 768px) {
    .forms-create-page {
        padding: 1rem;
    }

    .page-header h1 {
        font-size: 1.4rem;
    }

    .form-card {
        padding: 1.5rem;
        min-height: auto;
    }

    .form-group {
        grid-template-columns: 1fr;
    }

    .form-actions {
        flex-direction: column;
    }

    .btn {
        width: 100%;
    }

    .step-indicator {
        margin-bottom: 2rem;
    }

    .step-line {
        display: none;
    }

    .step-label {
        font-size: 0.65rem;
    }
}

@media (max-width: 600px) {
    .forms-create-page {
        padding: 0.5rem;
    }

    .page-header h1 {
        font-size: 1.2rem;
    }

    .form-card {
        padding: 1rem;
        border-radius: 12px;
    }

    .step-title {
        font-size: 1.1rem;
    }

    .file-upload-area {
        padding: 1.5rem;
    }

    .file-upload-area svg {
        width: 28px;
        height: 28px;
    }
}
</style>

<div class="forms-create-page">

    {{-- PROGRESS BAR --}}
    <div class="progress-container">
        <div class="progress-bar" id="progressBar"></div>
    </div>

    {{-- PAGE HEADER --}}
    <div class="page-header">
        <h1>NCC Admission Form</h1>
        <p>Step <span id="currentStep">1</span> of <span id="totalSteps">5</span> - Complete application for NCC enrollment</p>
    </div>

    {{-- STEP INDICATOR --}}
    <div class="step-indicator">
        <div class="step active" data-step="1">
            <div class="step-number">1</div>
            <div class="step-label">Personal</div>
        </div>
        <div class="step-line" id="line-1"></div>
        <div class="step" data-step="2">
            <div class="step-number">2</div>
            <div class="step-label">Address</div>
        </div>
        <div class="step-line" id="line-2"></div>
        <div class="step" data-step="3">
            <div class="step-number">3</div>
            <div class="step-label">Education</div>
        </div>
        <div class="step-line" id="line-3"></div>
        <div class="step" data-step="4">
            <div class="step-number">4</div>
            <div class="step-label">Documents</div>
        </div>
        <div class="step-line" id="line-4"></div>
        <div class="step" data-step="5">
            <div class="step-number">5</div>
            <div class="step-label">Confirm</div>
        </div>
    </div>

    {{-- FORM --}}
    <form action="{{ route('admin.forms.store') }}" method="POST" enctype="multipart/form-data" class="form-container" id="admissionForm">
        @csrf

        <div class="form-card">
            <div class="form-content">

                {{-- STEP 1: PERSONAL INFORMATION --}}
                <div class="form-step active" data-step="1">
                    <div class="step-title">
                        <svg fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                            <path d="M20 21v-2a4 4 0 0 0-4-4H8a4 4 0 0 0-4 4v2M12 3a4 4 0 1 0 0 8 4 4 0 0 0 0-8z"/>
                        </svg>
                        Personal Information
                    </div>
                    <div class="step-desc">Enter your basic personal details</div>

                    <div class="info-section">
                        <svg fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                            <circle cx="12" cy="12" r="10"/><line x1="12" y1="16" x2="12" y2="12"/><line x1="12" y1="8" x2="12.01" y2="8"/>
                        </svg>
                        <div>All information must be accurate and match your ID documents.</div>
                    </div>

                    <div class="form-group">
                        <div class="form-field @error('first_name') error @enderror">
                            <label for="first_name">First Name <span class="required">*</span></label>
                            <input type="text" id="first_name" name="first_name" placeholder="Enter your first name" value="{{ old('first_name') }}" required>
                            @error('first_name')<div class="error-message">{{ $message }}</div>@enderror
                        </div>
                        <div class="form-field @error('last_name') error @enderror">
                            <label for="last_name">Last Name <span class="required">*</span></label>
                            <input type="text" id="last_name" name="last_name" placeholder="Enter your last name" value="{{ old('last_name') }}" required>
                            @error('last_name')<div class="error-message">{{ $message }}</div>@enderror
                        </div>
                    </div>

                    <div class="form-group">
                        <div class="form-field @error('date_of_birth') error @enderror">
                            <label for="date_of_birth">Date of Birth <span class="required">*</span></label>
                            <input type="date" id="date_of_birth" name="date_of_birth" value="{{ old('date_of_birth') }}" required>
                            @error('date_of_birth')<div class="error-message">{{ $message }}</div>@enderror
                            <div class="field-hint">Must be 16+ years old</div>
                        </div>
                        <div class="form-field @error('gender') error @enderror">
                            <label for="gender">Gender <span class="required">*</span></label>
                            <select id="gender" name="gender" required>
                                <option value="">-- Select Gender --</option>
                                <option value="male" {{ old('gender') === 'male' ? 'selected' : '' }}>Male</option>
                                <option value="female" {{ old('gender') === 'female' ? 'selected' : '' }}>Female</option>
                                <option value="other" {{ old('gender') === 'other' ? 'selected' : '' }}>Other</option>
                            </select>
                            @error('gender')<div class="error-message">{{ $message }}</div>@enderror
                        </div>
                    </div>

                    <div class="form-group">
                        <div class="form-field @error('email') error @enderror">
                            <label for="email">Email Address <span class="required">*</span></label>
                            <input type="email" id="email" name="email" placeholder="your.email@example.com" value="{{ old('email') }}" required>
                            @error('email')<div class="error-message">{{ $message }}</div>@enderror
                        </div>
                        <div class="form-field @error('phone') error @enderror">
                            <label for="phone">Phone Number <span class="required">*</span></label>
                            <input type="tel" id="phone" name="phone" placeholder="10-digit mobile" value="{{ old('phone') }}" pattern="[0-9]{10}" required>
                            @error('phone')<div class="error-message">{{ $message }}</div>@enderror
                        </div>
                    </div>
                </div>

                {{-- STEP 2: ADDRESS --}}
                <div class="form-step" data-step="2">
                    <div class="step-title">
                        <svg fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                            <path d="M21 10c0 7-9 13-9 13s-9-6-9-13a9 9 0 0 1 18 0z"/><circle cx="12" cy="10" r="3"/>
                        </svg>
                        Address & Contact
                    </div>
                    <div class="step-desc">Provide your residential address information</div>

                    <div class="form-group full">
                        <div class="form-field @error('street_address') error @enderror">
                            <label for="street_address">Street Address <span class="required">*</span></label>
                            <input type="text" id="street_address" name="street_address" placeholder="House No., Street Name" value="{{ old('street_address') }}" required>
                            @error('street_address')<div class="error-message">{{ $message }}</div>@enderror
                        </div>
                    </div>

                    <div class="form-group">
                        <div class="form-field @error('city') error @enderror">
                            <label for="city">City <span class="required">*</span></label>
                            <input type="text" id="city" name="city" placeholder="Enter city name" value="{{ old('city') }}" required>
                            @error('city')<div class="error-message">{{ $message }}</div>@enderror
                        </div>
                        <div class="form-field @error('state') error @enderror">
                            <label for="state">State <span class="required">*</span></label>
                            <input type="text" id="state" name="state" placeholder="Enter state name" value="{{ old('state') }}" required>
                            @error('state')<div class="error-message">{{ $message }}</div>@enderror
                        </div>
                    </div>

                    <div class="form-group">
                        <div class="form-field @error('pincode') error @enderror">
                            <label for="pincode">Postal Code <span class="required">*</span></label>
                            <input type="text" id="pincode" name="pincode" placeholder="6-digit pincode" pattern="[0-9]{6}" value="{{ old('pincode') }}" required>
                            @error('pincode')<div class="error-message">{{ $message }}</div>@enderror
                        </div>
                        <div class="form-field @error('country') error @enderror">
                            <label for="country">Country <span class="required">*</span></label>
                            <input type="text" id="country" name="country" placeholder="India" value="{{ old('country', 'India') }}" required>
                            @error('country')<div class="error-message">{{ $message }}</div>@enderror
                        </div>
                    </div>
                </div>

                {{-- STEP 3: EDUCATION --}}
                <div class="form-step" data-step="3">
                    <div class="step-title">
                        <svg fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                            <path d="M4 19.5A2.5 2.5 0 0 1 6.5 17H20"/><path d="M6.5 2H20v20H6.5A2.5 2.5 0 0 1 4 19.5v-15A2.5 2.5 0 0 1 6.5 2z"/>
                        </svg>
                        Education Details
                    </div>
                    <div class="step-desc">Enter your current educational information</div>

                    <div class="form-group">
                        <div class="form-field @error('education_level') error @enderror">
                            <label for="education_level">Education Level <span class="required">*</span></label>
                            <select id="education_level" name="education_level" required onchange="updateDocumentFields()">
                                <option value="">-- Select Level --</option>
                                <option value="12th" {{ old('education_level') === '12th' ? 'selected' : '' }}>12th (Senior Secondary)</option>
                                <option value="fy" {{ old('education_level') === 'fy' ? 'selected' : '' }}>First Year (FY)</option>
                                <option value="sy" {{ old('education_level') === 'sy' ? 'selected' : '' }}>Second Year (SY)</option>
                                <option value="ty" {{ old('education_level') === 'ty' ? 'selected' : '' }}>Third Year (TY)</option>
                                <option value="postgraduate" {{ old('education_level') === 'postgraduate' ? 'selected' : '' }}>Postgraduate</option>
                            </select>
                            @error('education_level')<div class="error-message">{{ $message }}</div>@enderror
                        </div>
                        <div class="form-field @error('institution') error @enderror">
                            <label for="institution">Institution/College Name <span class="required">*</span></label>
                            <input type="text" id="institution" name="institution" placeholder="Enter college/school name" value="{{ old('institution') }}" required>
                            @error('institution')<div class="error-message">{{ $message }}</div>@enderror
                        </div>
                    </div>

                    <div class="form-group">
                        <div class="form-field @error('roll_number') error @enderror">
                            <label for="roll_number">Roll/Registration Number <span class="required">*</span></label>
                            <input type="text" id="roll_number" name="roll_number" placeholder="Your roll/registration number" value="{{ old('roll_number') }}" required>
                            @error('roll_number')<div class="error-message">{{ $message }}</div>@enderror
                        </div>
                        <div class="form-field @error('cgpa') error @enderror">
                            <label for="cgpa">Current CGPA / Percentage <span class="required">*</span></label>
                            <input type="number" id="cgpa" name="cgpa" placeholder="8.50" step="0.01" min="0" max="10" value="{{ old('cgpa') }}" required>
                            @error('cgpa')<div class="error-message">{{ $message }}</div>@enderror
                        </div>
                    </div>
                </div>

                {{-- STEP 4: DOCUMENTS --}}
                <div class="form-step" data-step="4">
                    <div class="step-title">
                        <svg fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                            <path d="M9 12h6m-6 4h6m2-8H7a2 2 0 0 0-2 2v12a2 2 0 0 0 2 2h10a2 2 0 0 0 2-2V8a2 2 0 0 0-2-2z"/>
                        </svg>
                        Upload Documents
                    </div>
                    <div class="step-desc">Upload required supporting documents (PDF, JPG, PNG - Max 5MB)</div>

                    {{-- ID Proof --}}
                    <div style="margin-bottom: 2rem;">
                        <h4 style="font-size: 0.95rem; font-weight: 600; margin-bottom: 1rem; color: var(--tx1);">
                            Identity Proof <span class="required">*</span>
                        </h4>
                        <div class="form-group full">
                            <div class="form-field @error('id_proof_type') error @enderror">
                                <label for="id_proof_type">Select ID Type <span class="required">*</span></label>
                                <select id="id_proof_type" name="id_proof_type" required>
                                    <option value="">-- Select ID Type --</option>
                                    <option value="aadhar" {{ old('id_proof_type') === 'aadhar' ? 'selected' : '' }}>Aadhar Card</option>
                                    <option value="pan" {{ old('id_proof_type') === 'pan' ? 'selected' : '' }}>PAN Card</option>
                                    <option value="passport" {{ old('id_proof_type') === 'passport' ? 'selected' : '' }}>Passport</option>
                                </select>
                                @error('id_proof_type')<div class="error-message">{{ $message }}</div>@enderror
                            </div>
                        </div>
                        <div class="form-group full">
                            <div class="form-field @error('id_proof_file') error @enderror">
                                <label for="id_proof_file">Upload Document <span class="required">*</span></label>
                                <div class="file-upload-area" onclick="document.getElementById('id_proof_file').click()">
                                    <svg fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                        <path d="M21 15v4a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2v-4"/><polyline points="17 8 12 3 7 8"/><line x1="12" y1="3" x2="12" y2="15"/>
                                    </svg>
                                    <p>Click to upload or drag and drop</p>
                                    <span class="file-hint">PDF, JPG, PNG (Max 5MB)</span>
                                </div>
                                <input type="file" id="id_proof_file" name="id_proof_file" accept="image/*,.pdf" style="display:none;" required onchange="showFileName(this)">
                                <div id="id_proof_name" class="file-name"></div>
                                @error('id_proof_file')<div class="error-message">{{ $message }}</div>@enderror
                            </div>
                        </div>
                    </div>

                    {{-- Education Documents --}}
                    <div id="doc-12th" style="display:none; margin-bottom: 2rem;">
                        <h4 style="font-size: 0.95rem; font-weight: 600; margin-bottom: 1rem; color: var(--tx1);">12th Marksheet <span class="required">*</span></h4>
                        <div class="file-upload-area" onclick="document.getElementById('marksheet_12th').click()">
                            <svg fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path d="M21 15v4a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2v-4"/><polyline points="17 8 12 3 7 8"/><line x1="12" y1="3" x2="12" y2="15"/></svg>
                            <p>Click to upload or drag and drop</p>
                            <span class="file-hint">PDF, JPG, PNG (Max 5MB)</span>
                        </div>
                        <input type="file" id="marksheet_12th" name="marksheet_12th" accept="image/*,.pdf" style="display:none;" onchange="showFileName(this)">
                        <div id="marksheet_12th_name" class="file-name"></div>
                    </div>

                    <div id="doc-fy" style="display:none; margin-bottom: 2rem;">
                        <h4 style="font-size: 0.95rem; font-weight: 600; margin-bottom: 1rem; color: var(--tx1);">FY Marksheet/Transcript <span class="required">*</span></h4>
                        <div class="file-upload-area" onclick="document.getElementById('marksheet_fy').click()">
                            <svg fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path d="M21 15v4a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2v-4"/><polyline points="17 8 12 3 7 8"/><line x1="12" y1="3" x2="12" y2="15"/></svg>
                            <p>Click to upload or drag and drop</p>
                            <span class="file-hint">PDF, JPG, PNG (Max 5MB)</span>
                        </div>
                        <input type="file" id="marksheet_fy" name="marksheet_fy" accept="image/*,.pdf" style="display:none;" onchange="showFileName(this)">
                        <div id="marksheet_fy_name" class="file-name"></div>
                    </div>

                    <div id="doc-sy" style="display:none; margin-bottom: 2rem;">
                        <h4 style="font-size: 0.95rem; font-weight: 600; margin-bottom: 1rem; color: var(--tx1);">SY Marksheet/Transcript <span class="required">*</span></h4>
                        <div class="file-upload-area" onclick="document.getElementById('marksheet_sy').click()">
                            <svg fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path d="M21 15v4a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2v-4"/><polyline points="17 8 12 3 7 8"/><line x1="12" y1="3" x2="12" y2="15"/></svg>
                            <p>Click to upload or drag and drop</p>
                            <span class="file-hint">PDF, JPG, PNG (Max 5MB)</span>
                        </div>
                        <input type="file" id="marksheet_sy" name="marksheet_sy" accept="image/*,.pdf" style="display:none;" onchange="showFileName(this)">
                        <div id="marksheet_sy_name" class="file-name"></div>
                    </div>

                    <div id="doc-ty" style="display:none; margin-bottom: 2rem;">
                        <h4 style="font-size: 0.95rem; font-weight: 600; margin-bottom: 1rem; color: var(--tx1);">TY Marksheet/Transcript <span class="required">*</span></h4>
                        <div class="file-upload-area" onclick="document.getElementById('marksheet_ty').click()">
                            <svg fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path d="M21 15v4a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2v-4"/><polyline points="17 8 12 3 7 8"/><line x1="12" y1="3" x2="12" y2="15"/></svg>
                            <p>Click to upload or drag and drop</p>
                            <span class="file-hint">PDF, JPG, PNG (Max 5MB)</span>
                        </div>
                        <input type="file" id="marksheet_ty" name="marksheet_ty" accept="image/*,.pdf" style="display:none;" onchange="showFileName(this)">
                        <div id="marksheet_ty_name" class="file-name"></div>
                    </div>

                    <div id="doc-postgraduate" style="display:none; margin-bottom: 2rem;">
                        <h4 style="font-size: 0.95rem; font-weight: 600; margin-bottom: 1rem; color: var(--tx1);">Degree/Certificate <span class="required">*</span></h4>
                        <div class="file-upload-area" onclick="document.getElementById('degree_certificate').click()">
                            <svg fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path d="M21 15v4a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2v-4"/><polyline points="17 8 12 3 7 8"/><line x1="12" y1="3" x2="12" y2="15"/></svg>
                            <p>Click to upload or drag and drop</p>
                            <span class="file-hint">PDF, JPG, PNG (Max 5MB)</span>
                        </div>
                        <input type="file" id="degree_certificate" name="degree_certificate" accept="image/*,.pdf" style="display:none;" onchange="showFileName(this)">
                        <div id="degree_certificate_name" class="file-name"></div>
                    </div>

                    {{-- Passport Photo --}}
                    <div style="margin-bottom: 2rem;">
                        <h4 style="font-size: 0.95rem; font-weight: 600; margin-bottom: 1rem; color: var(--tx1);">Passport Size Photograph <span class="required">*</span></h4>
                        <div class="file-upload-area" onclick="document.getElementById('photo').click()">
                            <svg fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                <rect x="3" y="3" width="18" height="18" rx="2" ry="2"/><circle cx="8.5" cy="8.5" r="1.5"/><polyline points="21 15 16 10 5 21"/>
                            </svg>
                            <p>Click to upload or drag and drop</p>
                            <span class="file-hint">JPG, PNG (Max 2MB) - 4x6 cm recommended</span>
                        </div>
                        <input type="file" id="photo" name="photo" accept="image/*" style="display:none;" required onchange="showFileName(this)">
                        <div id="photo_name" class="file-name"></div>
                    </div>
                </div>

                {{-- STEP 5: CONFIRMATION --}}
                <div class="form-step" data-step="5">
                    <div class="step-title">
                        <svg fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                            <path d="M12 22s8-4 8-10V5l-8-3-8 3v7c0 6 8 10 8 10z"/>
                        </svg>
                        Confirm & Declaration
                    </div>
                    <div class="step-desc">Please review your information and accept the declaration</div>

                    <div class="info-section">
                        <svg fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                            <circle cx="12" cy="12" r="10"/><line x1="12" y1="16" x2="12" y2="12"/><line x1="12" y1="8" x2="12.01" y2="8"/>
                        </svg>
                        <div>Please carefully review all the information you have provided before submitting your application.</div>
                    </div>

                    <div class="form-group full" style="margin-bottom: 1.5rem;">
                        <label class="checkbox-label @error('declaration') error @enderror">
                            <input type="checkbox" name="declaration" value="1" {{ old('declaration') ? 'checked' : '' }} required>
                            <span>I declare that all information provided in this application is true and accurate. I am aware of NCC code of conduct and agree to follow all rules and regulations.</span>
                        </label>
                        @error('declaration')<div class="error-message">{{ $message }}</div>@enderror
                    </div>

                    <div class="form-group full" style="margin-bottom: 0;">
                        <label class="checkbox-label @error('consent') error @enderror">
                            <input type="checkbox" name="consent" value="1" {{ old('consent') ? 'checked' : '' }} required>
                            <span>I consent to the processing of my personal data as per NCC privacy policy and regulations.</span>
                        </label>
                        @error('consent')<div class="error-message">{{ $message }}</div>@enderror
                    </div>
                </div>

            </div>

            {{-- FORM ACTIONS --}}
            <div class="form-actions">
                <button type="button" class="btn btn-secondary" id="prevBtn" onclick="changeStep(-1)" style="display:none;">
                    <svg fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                        <line x1="19" y1="12" x2="5" y2="12"/><polyline points="12 19 5 12 12 5"/>
                    </svg>
                    Previous
                </button>
                <button type="button" class="btn btn-primary" id="nextBtn" onclick="changeStep(1)">
                    Next
                    <svg fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                        <line x1="5" y1="12" x2="19" y2="12"/><polyline points="12 5 19 12 12 19"/>
                    </svg>
                </button>
                <button type="submit" class="btn btn-primary" id="submitBtn" style="display:none;">
                    <svg fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                        <polyline points="20 6 9 17 4 12"/>
                    </svg>
                    Submit Application
                </button>
            </div>

        </div>

    </form>

</div>

<script>
let currentStep = 1;
const totalSteps = 5;

function showStep(n) {
    const steps = document.querySelectorAll('.form-step');
    
    if (n > totalSteps) currentStep = totalSteps;
    if (n < 1) currentStep = 1;
    
    steps.forEach(step => step.classList.remove('active'));
    document.querySelector(`.form-step[data-step="${currentStep}"]`).classList.add('active');
    
    // Update indicators
    document.querySelectorAll('.step').forEach((step, index) => {
        const stepNum = index + 1;
        step.classList.remove('active', 'completed');
        if (stepNum < currentStep) step.classList.add('completed');
        if (stepNum === currentStep) step.classList.add('active');
    });
    
    // Update progress bar
    const progress = (currentStep / totalSteps) * 100;
    document.getElementById('progressBar').style.width = progress + '%';
    
    // Update step counter
    document.getElementById('currentStep').textContent = currentStep;
    
    // Update buttons
    document.getElementById('prevBtn').style.display = currentStep === 1 ? 'none' : 'flex';
    document.getElementById('nextBtn').style.display = currentStep === totalSteps ? 'none' : 'flex';
    document.getElementById('submitBtn').style.display = currentStep === totalSteps ? 'flex' : 'none';
    
    // Update lines
    for (let i = 1; i < totalSteps; i++) {
        const line = document.getElementById(`line-${i}`);
        if (i < currentStep) line.classList.add('completed');
        else line.classList.remove('completed');
    }
}

function changeStep(n) {
    if (validateCurrentStep()) {
        currentStep += n;
        showStep(currentStep);
        window.scrollTo({ top: 0, behavior: 'smooth' });
    }
}

function validateCurrentStep() {
    const formStep = document.querySelector(`.form-step[data-step="${currentStep}"]`);
    const requiredFields = formStep.querySelectorAll('[required]');
    
    for (let field of requiredFields) {
        if (!field.value) {
            field.focus();
            return false;
        }
    }
    return true;
}

function updateDocumentFields() {
    const educationLevel = document.getElementById('education_level').value;
    
    document.getElementById('doc-12th').style.display = 'none';
    document.getElementById('doc-fy').style.display = 'none';
    document.getElementById('doc-sy').style.display = 'none';
    document.getElementById('doc-ty').style.display = 'none';
    document.getElementById('doc-postgraduate').style.display = 'none';
    
    if (educationLevel === '12th') document.getElementById('doc-12th').style.display = 'block';
    else if (educationLevel === 'fy') document.getElementById('doc-fy').style.display = 'block';
    else if (educationLevel === 'sy') document.getElementById('doc-sy').style.display = 'block';
    else if (educationLevel === 'ty') document.getElementById('doc-ty').style.display = 'block';
    else if (educationLevel === 'postgraduate') document.getElementById('doc-postgraduate').style.display = 'block';
}

function showFileName(input) {
    if (input.files && input.files[0]) {
        const fileName = input.files[0].name;
        const fileSize = (input.files[0].size / 1024).toFixed(2);
        const displayName = document.getElementById(input.id + '_name');
        if (displayName) {
            displayName.innerHTML = `<svg fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><polyline points="20 6 9 17 4 12"/></svg> ${fileName} (${fileSize}KB)`;
        }
    }
}

// Initialize
document.addEventListener('DOMContentLoaded', function() {
    showStep(currentStep);
});

// Form submission
document.getElementById('admissionForm').addEventListener('submit', function(e) {
    e.preventDefault();
    
    if (validateCurrentStep()) {
        this.submit();
    }
});
</script>

@endsection
