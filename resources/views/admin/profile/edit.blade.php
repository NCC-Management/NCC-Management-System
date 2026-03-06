@extends('layouts.admin')

@section('content')
<div style="max-width:1200px;margin:0 auto;">
    {{-- Page Header --}}
    <div style="margin-bottom:2rem;">
        <h1 style="font-size:2rem;font-weight:700;color:var(--tx1);margin-bottom:.5rem;font-family:'Syne',sans-serif;letter-spacing:-.02em;">My Profile</h1>
        <p style="color:var(--tx2);font-size:.95rem;">Manage your account settings and preferences</p>
    </div>

    {{-- Success Message --}}
    @if(session('success'))
        <div style="background:rgba(31,213,122,.12);border:1px solid rgba(31,213,122,.3);border-radius:12px;padding:1rem;margin-bottom:2rem;color:var(--green);font-size:.9rem;">
            ✓ {{ session('success') }}
        </div>
    @endif

    <div style="display:grid;grid-template-columns:1fr 2fr;gap:2rem;@media(max-width:1024px){grid-template-columns:1fr;}">
        
        {{-- Sidebar --}}
        <div style="display:flex;flex-direction:column;gap:1rem;">
            {{-- Profile Card --}}
            <div style="background:var(--bg-card);border:1px solid var(--bdr);border-radius:16px;padding:2rem;text-align:center;">
                <div style="width:80px;height:80px;border-radius:12px;background:linear-gradient(135deg,var(--blue),var(--cyan));display:flex;align-items:center;justify-content:center;margin:0 auto 1.5rem;box-shadow:0 8px 24px rgba(61,126,255,.3);">
                    <span style="font-family:'Syne',sans-serif;font-size:2rem;font-weight:700;color:#fff;">{{ strtoupper(substr(auth()->user()->name ?? 'A', 0, 1)) }}</span>
                </div>
                <h2 style="color:var(--tx1);font-size:1.3rem;font-weight:700;margin-bottom:.5rem;">{{ auth()->user()->name ?? 'Administrator' }}</h2>
                <p style="color:var(--tx2);font-size:.9rem;margin-bottom:1.5rem;">Administrator Account</p>
                <p style="color:var(--tx3);font-size:.85rem;">{{ auth()->user()->email ?? 'admin@ncc.edu' }}</p>
            </div>

            {{-- Quick Stats --}}
            <div style="background:var(--bg-card);border:1px solid var(--bdr);border-radius:16px;padding:1.5rem;">
                <div style="display:flex;justify-content:space-between;align-items:center;margin-bottom:1rem;padding-bottom:1rem;border-bottom:1px solid var(--bdr);">
                    <span style="color:var(--tx2);font-size:.9rem;font-weight:500;">Account Status</span>
                    <span style="background:rgba(31,213,122,.15);color:var(--green);padding:.3rem .8rem;border-radius:20px;font-size:.8rem;font-weight:600;">Active</span>
                </div>
                <div style="display:flex;justify-content:space-between;align-items:center;margin-bottom:1rem;">
                    <span style="color:var(--tx2);font-size:.9rem;font-weight:500;">Member Since</span>
                    <span style="color:var(--tx1);font-size:.9rem;font-weight:600;">{{ auth()->user()->created_at->format('M d, Y') }}</span>
                </div>
                <div style="display:flex;justify-content:space-between;align-items:center;">
                    <span style="color:var(--tx2);font-size:.9rem;font-weight:500;">Last Login</span>
                    <span style="color:var(--tx1);font-size:.9rem;font-weight:600;">Today</span>
                </div>
            </div>
        </div>

        {{-- Main Content --}}
        <div style="display:flex;flex-direction:column;gap:1.5rem;">
            
            {{-- Personal Information Section --}}
            <div style="background:var(--bg-card);border:1px solid var(--bdr);border-radius:16px;padding:2rem;">
                <h3 style="color:var(--tx1);font-size:1.1rem;font-weight:700;margin-bottom:1.5rem;font-family:'Syne',sans-serif;">Personal Information</h3>
                
                <form action="{{ route('admin.profile.update') }}" method="POST" style="display:flex;flex-direction:column;gap:1.5rem;">
                    @csrf
                    @method('PUT')

                    {{-- Full Name --}}
                    <div>
                        <label style="display:block;color:var(--tx2);font-size:.9rem;font-weight:600;margin-bottom:.5rem;">Full Name</label>
                        <input type="text" name="name" value="{{ auth()->user()->name }}" style="width:100%;padding:.75rem 1rem;background:var(--surf);border:1px solid var(--bdr);border-radius:10px;color:var(--tx1);font-size:.95rem;font-family:inherit;transition:all .2s;" required>
                        @error('name')
                            <p style="color:var(--rose);font-size:.85rem;margin-top:.25rem;">{{ $message }}</p>
                        @enderror
                    </div>

                    {{-- Email --}}
                    <div>
                        <label style="display:block;color:var(--tx2);font-size:.9rem;font-weight:600;margin-bottom:.5rem;">Email Address</label>
                        <input type="email" name="email" value="{{ auth()->user()->email }}" style="width:100%;padding:.75rem 1rem;background:var(--surf);border:1px solid var(--bdr);border-radius:10px;color:var(--tx1);font-size:.95rem;font-family:inherit;transition:all .2s;" required>
                        @error('email')
                            <p style="color:var(--rose);font-size:.85rem;margin-top:.25rem;">{{ $message }}</p>
                        @enderror
                    </div>

                    {{-- Phone --}}
                    <div>
                        <label style="display:block;color:var(--tx2);font-size:.9rem;font-weight:600;margin-bottom:.5rem;">Phone Number (Optional)</label>
                        <input type="tel" name="phone" value="{{ auth()->user()->phone ?? '' }}" placeholder="+91 XXXXX XXXXX" style="width:100%;padding:.75rem 1rem;background:var(--surf);border:1px solid var(--bdr);border-radius:10px;color:var(--tx1);font-size:.95rem;font-family:inherit;transition:all .2s;">
                        @error('phone')
                            <p style="color:var(--rose);font-size:.85rem;margin-top:.25rem;">{{ $message }}</p>
                        @enderror
                    </div>

                    {{-- Submit Button --}}
                    <button type="submit" style="align-self:flex-start;padding:.75rem 2rem;background:linear-gradient(135deg,var(--blue),var(--cyan));color:#fff;border:none;border-radius:10px;font-weight:600;font-size:.95rem;cursor:pointer;transition:all .2s;box-shadow:0 4px 12px rgba(61,126,255,.3);">
                        Save Changes
                    </button>
                </form>
            </div>

            {{-- Security Section --}}
            <div style="background:var(--bg-card);border:1px solid var(--bdr);border-radius:16px;padding:2rem;">
                <h3 style="color:var(--tx1);font-size:1.1rem;font-weight:700;margin-bottom:1.5rem;font-family:'Syne',sans-serif;">Security Settings</h3>
                
                <form action="{{ route('admin.profile.password.update') }}" method="POST" style="display:flex;flex-direction:column;gap:1.5rem;">
                    @csrf
                    @method('PUT')

                    {{-- Current Password --}}
                    <div>
                        <label style="display:block;color:var(--tx2);font-size:.9rem;font-weight:600;margin-bottom:.5rem;">Current Password</label>
                        <input type="password" name="current_password" style="width:100%;padding:.75rem 1rem;background:var(--surf);border:1px solid var(--bdr);border-radius:10px;color:var(--tx1);font-size:.95rem;font-family:inherit;transition:all .2s;" required>
                        @error('current_password')
                            <p style="color:var(--rose);font-size:.85rem;margin-top:.25rem;">{{ $message }}</p>
                        @enderror
                    </div>

                    {{-- New Password --}}
                    <div>
                        <label style="display:block;color:var(--tx2);font-size:.9rem;font-weight:600;margin-bottom:.5rem;">New Password</label>
                        <input type="password" name="password" style="width:100%;padding:.75rem 1rem;background:var(--surf);border:1px solid var(--bdr);border-radius:10px;color:var(--tx1);font-size:.95rem;font-family:inherit;transition:all .2s;" required>
                        <p style="color:var(--tx3);font-size:.8rem;margin-top:.5rem;">Minimum 8 characters</p>
                        @error('password')
                            <p style="color:var(--rose);font-size:.85rem;margin-top:.25rem;">{{ $message }}</p>
                        @enderror
                    </div>

                    {{-- Confirm Password --}}
                    <div>
                        <label style="display:block;color:var(--tx2);font-size:.9rem;font-weight:600;margin-bottom:.5rem;">Confirm Password</label>
                        <input type="password" name="password_confirmation" style="width:100%;padding:.75rem 1rem;background:var(--surf);border:1px solid var(--bdr);border-radius:10px;color:var(--tx1);font-size:.95rem;font-family:inherit;transition:all .2s;" required>
                        @error('password_confirmation')
                            <p style="color:var(--rose);font-size:.85rem;margin-top:.25rem;">{{ $message }}</p>
                        @enderror
                    </div>

                    {{-- Submit Button --}}
                    <button type="submit" style="align-self:flex-start;padding:.75rem 2rem;background:linear-gradient(135deg,var(--rose),#FF8090);color:#fff;border:none;border-radius:10px;font-weight:600;font-size:.95rem;cursor:pointer;transition:all .2s;box-shadow:0 4px 12px rgba(240,69,90,.3);">
                        Update Password
                    </button>
                </form>
            </div>

            {{-- Additional Info Section --}}
            <div style="background:var(--bg-card);border:1px solid var(--bdr);border-radius:16px;padding:2rem;">
                <h3 style="color:var(--tx1);font-size:1.1rem;font-weight:700;margin-bottom:1.5rem;font-family:'Syne',sans-serif;">Account Information</h3>
                
                <div style="display:grid;grid-template-columns:1fr 1fr;gap:2rem;@media(max-width:768px){grid-template-columns:1fr;}">
                    <div>
                        <p style="color:var(--tx3);font-size:.85rem;text-transform:uppercase;letter-spacing:.05em;font-weight:600;margin-bottom:.5rem;">Account ID</p>
                        <p style="color:var(--tx1);font-size:.95rem;font-weight:500;">{{ auth()->user()->id }}</p>
                    </div>
                    <div>
                        <p style="color:var(--tx3);font-size:.85rem;text-transform:uppercase;letter-spacing:.05em;font-weight:600;margin-bottom:.5rem;">Account Type</p>
                        <span style="background:rgba(61,126,255,.12);color:var(--blue);padding:.3rem .8rem;border-radius:6px;font-size:.85rem;font-weight:600;display:inline-block;">Administrator</span>
                    </div>
                    <div>
                        <p style="color:var(--tx3);font-size:.85rem;text-transform:uppercase;letter-spacing:.05em;font-weight:600;margin-bottom:.5rem;">Joined Date</p>
                        <p style="color:var(--tx1);font-size:.95rem;font-weight:500;">{{ auth()->user()->created_at->format('F d, Y') }}</p>
                    </div>
                    <div>
                        <p style="color:var(--tx3);font-size:.85rem;text-transform:uppercase;letter-spacing:.05em;font-weight:600;margin-bottom:.5rem;">Last Updated</p>
                        <p style="color:var(--tx1);font-size:.95rem;font-weight:500;">{{ auth()->user()->updated_at->format('F d, Y') }}</p>
                    </div>
                </div>
            </div>

            {{-- Danger Zone --}}
            <div style="background:rgba(240,69,90,.08);border:1px solid rgba(240,69,90,.25);border-radius:16px;padding:2rem;">
                <h3 style="color:var(--rose);font-size:1.1rem;font-weight:700;margin-bottom:1rem;font-family:'Syne',sans-serif;">Danger Zone</h3>
                <p style="color:var(--tx2);font-size:.9rem;margin-bottom:1.5rem;">These actions cannot be undone. Please proceed with caution.</p>
                <button style="padding:.75rem 2rem;background:rgba(240,69,90,.15);color:var(--rose);border:1px solid var(--rose);border-radius:10px;font-weight:600;font-size:.95rem;cursor:pointer;transition:all .2s;" disabled>
                    Delete Account
                </button>
                <p style="color:var(--tx3);font-size:.8rem;margin-top:.5rem;">Contact support to permanently delete your account</p>
            </div>
        </div>
    </div>
</div>

<style>
    input[type="text"],
    input[type="email"],
    input[type="tel"],
    input[type="password"] {
        transition: all 0.2s ease;
    }
    input[type="text"]:focus,
    input[type="email"]:focus,
    input[type="tel"]:focus,
    input[type="password"]:focus {
        background: var(--surf-hov);
        border-color: var(--blue);
        box-shadow: 0 0 0 3px rgba(61, 126, 255, 0.15);
        outline: none;
    }
    button:hover:not(:disabled) {
        transform: translateY(-2px);
        box-shadow: 0 6px 16px rgba(0, 0, 0, 0.3);
    }
    button:disabled {
        opacity: 0.5;
        cursor: not-allowed;
    }
    @media (max-width: 768px) {
        div[style*="display:grid"] {
            grid-template-columns: 1fr !important;
        }
    }
</style>
@endsection
