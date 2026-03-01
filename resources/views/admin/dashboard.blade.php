@extends('layouts.admin')

@section('content')

<div class="space-y-8">

    <!-- Page Title -->
    <div>
        <h1 class="text-3xl font-bold text-gray-800">
            NCC Admin Dashboard
        </h1>
        <p class="text-gray-400 mt-1">
            Manage cadets, events and attendance efficiently
        </p>
    </div>

    <!-- Stats Cards -->
    <div class="grid grid-cols-1 md:grid-cols-4 gap-6">

        <!-- Total Cadets -->
        <div class="bg-white p-6 rounded-xl shadow">
            <h3 class="text-gray-400 text-sm uppercase tracking-wide">
                Total Cadets
            </h3>
            <p class="text-3xl font-bold text-gray-800 mt-2">
                {{ $totalCadets }}
            </p>
        </div>

        <!-- Total Events -->
        <div class="bg-white p-6 rounded-xl shadow">
            <h3 class="text-gray-400 text-sm uppercase tracking-wide">
                Total Events
            </h3>
            <p class="text-3xl font-bold text-gray-800 mt-2">
                {{ $totalEvents }}
            </p>
        </div>

        <!-- Present -->
        <div class="bg-white p-6 rounded-xl shadow">
            <h3 class="text-gray-400 text-sm uppercase tracking-wide">
                Present
            </h3>
            <p class="text-3xl font-bold text-green-600 mt-2">
                {{ $present }}
            </p>
        </div>

        <!-- Absent -->
        <div class="bg-white p-6 rounded-xl shadow">
            <h3 class="text-gray-400 text-sm uppercase tracking-wide">
                Absent
            </h3>
            <p class="text-3xl font-bold text-red-500 mt-2">
                {{ $absent }}
            </p>
        </div>

    </div>

    <!-- Charts Section -->
    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">

        <!-- Bar Chart -->
        <div class="bg-white p-6 rounded-xl shadow">
            <h3 class="text-lg font-semibold text-gray-700 mb-4">
                Attendance Overview
            </h3>
            <canvas id="attendanceChart"></canvas>
        </div>

        <!-- Doughnut Chart -->
        <div class="bg-white p-6 rounded-xl shadow">
            <h3 class="text-lg font-semibold text-gray-700 mb-4">
                Attendance Distribution
            </h3>
            <canvas id="pieChart"></canvas>
        </div>

    </div>

</div>

<!-- Chart JS -->
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

<script>
const present = {{ $present }};
const absent = {{ $absent }};

// Bar Chart
new Chart(document.getElementById('attendanceChart'), {
    type: 'bar',
    data: {
        labels: ['Present', 'Absent'],
        datasets: [{
            label: 'Attendance',
            data: [present, absent],
            backgroundColor: ['#10B981', '#EF4444']
        }]
    },
    options: {
        responsive: true,
        plugins: {
            legend: {
                labels: {
                    color: '#9CA3AF' // muted gray legend
                }
            }
        },
        scales: {
            x: {
                ticks: { color: '#6B7280' }
            },
            y: {
                ticks: { color: '#6B7280' }
            }
        }
    }
});

// Pie Chart
new Chart(document.getElementById('pieChart'), {
    type: 'doughnut',
    data: {
        labels: ['Present', 'Absent'],
        datasets: [{
            data: [present, absent],
            backgroundColor: ['#10B981', '#EF4444']
        }]
    },
    options: {
        plugins: {
            legend: {
                labels: {
                    color: '#6B7280'
                }
            }
        }
    }
});
</script>

@endsection