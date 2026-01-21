@extends('layouts.main')

@section('title', 'Admin Dashboard')

@section('content')
<style>
    .admin-hero {
        background: linear-gradient(135deg, #2563eb, #16a34a);
        color: #fff;
        border-radius: 18px;
        padding: 24px 28px;
        box-shadow: 0 10px 30px rgba(15,23,42,.35);
    }
    .admin-hero h2 {
        font-weight: 700;
        letter-spacing: .03em;
    }
    .admin-hero .badge-role {
        background: rgba(15,23,42,.2);
        border-radius: 999px;
        padding: 4px 12px;
        font-size: .8rem;
        text-transform: uppercase;
        letter-spacing: .08em;
    }
    .stat-card {
        border-radius: 16px;
        border: none;
        box-shadow: 0 8px 20px rgba(15,23,42,.08);
        transition: transform .18s ease, box-shadow .18s ease;
    }
    .stat-card:hover {
        transform: translateY(-3px);
        box-shadow: 0 12px 26px rgba(15,23,42,.16);
    }
    .stat-label {
        font-size: .85rem;
        text-transform: uppercase;
        letter-spacing: .09em;
        color: #64748b;
        font-weight: 600;
    }
    .stat-value {
        font-size: 1.6rem;
        font-weight: 700;
        color: #0f172a;
    }
    .trend-up {
        color: #16a34a;
        font-size: .85rem;
        font-weight: 600;
    }
    .trend-down {
        color: #b91c1c;
        font-size: .85rem;
        font-weight: 600;
    }
    .pill {
        display: inline-flex;
        align-items: center;
        border-radius: 999px;
        padding: 4px 10px;
        font-size: .78rem;
        background: #eff6ff;
        color: #1d4ed8;
        font-weight: 500;
    }
    .pill span {
        width: 8px;
        height: 8px;
        border-radius: 999px;
        margin-right: 6px;
        background: #22c55e;
    }
    .ai-card {
        border-radius: 16px;
        border: none;
        background: radial-gradient(circle at top left, #dbeafe, #f9fafb);
        box-shadow: 0 8px 24px rgba(15,23,42,.1);
        position: relative;
        overflow: hidden;
    }
    .ai-card::before {
        content: "";
        position: absolute;
        right: -40px;
        top: -40px;
        width: 160px;
        height: 160px;
        border-radius: 50%;
        background: rgba(37,99,235,.11);
        filter: blur(4px);
    }
    .ai-tag {
        font-size: .75rem;
        text-transform: uppercase;
        letter-spacing: .1em;
        color: #2563eb;
        font-weight: 700;
    }
    .ai-highlight {
        font-weight: 600;
        color: #0f172a;
    }
    .table-sm th,
    .table-sm td {
        vertical-align: middle;
        font-size: .86rem;
    }
</style>

<div class="container py-4 py-md-5">

    {{-- Top hero --}}
    <div class="admin-hero mb-4 mb-md-5">
        <div class="d-flex flex-column flex-md-row justify-content-between align-items-md-center">
            <div class="mb-3 mb-md-0">
                <div class="badge-role mb-2">
                    <i class="bi bi-shield-lock-fill me-1"></i> System Admin Panel
                </div>

                <h2 class="mb-1">Welcome back, Admin</h2>

                {{-- dynamic greeting --}}
                <p id="admin-greeting" class="mt-1 fw-bold" style="font-size: 1.1rem;"></p>

                <p class="mb-0">
                    Monitor donors, organizations and food donations from a single,
                    intelligent dashboard. This panel is designed for reporting and AI-based insights.
                </p>
            </div>

            <div class="text-md-end">
                <div class="pill mb-1">
                    <span></span> Live system status: Online
                </div>

                {{-- live clock --}}
                <p id="live-clock" class="mb-0 small fw-bold"></p>
            </div>
        </div>
    </div>

    <script>
        function updateClock() {
            const now = new Date();
            const options = {
                timeZone: "Asia/Dhaka",
                year: "numeric",
                month: "short",
                day: "numeric",
                hour: "2-digit",
                minute: "2-digit",
                second: "2-digit",
                hour12: true
            };
            const formatter = new Intl.DateTimeFormat('en-US', options);
            document.getElementById('live-clock').innerText = formatter.format(now);
        }
        setInterval(updateClock, 1000);
        updateClock();

        function updateGreeting() {
            const now = new Date();
            const hour = now.getHours();
            let greeting = "";

            if (hour >= 5 && hour < 12) {
                greeting = "Good Morning ☀️";
            } else if (hour >= 12 && hour < 17) {
                greeting = "Good Afternoon 🌤";
            } else if (hour >= 17 && hour < 21) {
                greeting = "Good Evening 🌆";
            } else {
                greeting = "Good Night🌙";
            }

            document.getElementById('admin-greeting').innerText = greeting;
        }
        updateGreeting();
    </script>

    {{-- Stats row --}}
    <div class="row g-3 mb-4">

        {{-- Total users --}}
        <div class="col-md-4">
            <div class="card stat-card h-100">
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-start mb-2">
                        <div>
                            <div class="stat-label">Total Users</div>
                            <div class="stat-value">
                                {{ $totalUsers ?? 0 }}
                            </div>
                        </div>
                        <div class="rounded-circle d-flex align-items-center justify-content-center"
                             style="width:40px;height:40px;background:#eef2ff;">
                            <i class="bi bi-people-fill text-primary"></i>
                        </div>
                    </div>

                    <div class="trend-up">
                        +0% · last 7 days
                    </div>

                    <p class="small text-muted mb-0">
                        Donors: {{ $totalDonors ?? 0 }},
                        NGOs: {{ $totalNgos ?? 0 }},
                        Admins: {{ $totalAdmins ?? 0 }}
                    </p>
                </div>
            </div>
        </div>

        {{-- Total donations (accepted + completed pickups) --}}
        <div class="col-md-4">
            <div class="card stat-card h-100">
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-start mb-2">
                        <div>
                            <div class="stat-label">Total Donations</div>

                            <div class="stat-value">
                                {{ $totalDonations ?? 0 }}
                            </div>
                        </div>

                        <div class="rounded-circle d-flex align-items-center justify-content-center"
                             style="width:40px;height:40px;background:#ecfdf3;">
                            <i class="bi bi-basket-fill text-success"></i>
                        </div>
                    </div>

                    <div class="trend-up">
                        +{{ $donationsThisWeek ?? 0 }} · this week
                    </div>

                    <p class="small text-muted mb-0">
                        Food pickup requests that have been <strong>accepted by NGOs
                        or completed</strong>.
                    </p>
                </div>
            </div>
        </div>

        {{-- Open requests (available donor posts) --}}
        <div class="col-md-4">
            <div class="card stat-card h-100">
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-start mb-2">
                        <div>
                            <div class="stat-label">Open Requests</div>

                            {{-- donor posted but no NGO yet --}}
                            <div class="stat-value">
                                {{ $openRequests ?? 0 }}
                            </div>
                        </div>

                        <div class="rounded-circle d-flex align-items-center justify-content-center"
                             style="width:40px;height:40px;background:#fef2f2;">
                            <i class="bi bi-exclamation-triangle-fill text-danger"></i>
                        </div>
                    </div>

                    <div class="text-danger small mb-1">
                        {{ $pendingApprovals ?? 0 }} donor posts waiting for NGOs
                    </div>

                    <p class="small text-muted mb-0">
                        Donor food donations that are still unassigned to any NGO.
                    </p>
                </div>
            </div>
        </div>

    </div>

    {{-- AI + Recent activity --}}
    <div class="row g-3">
        <div class="col-lg-5">
        <div class="card ai-card h-100">
        <div class="card-body position-relative">
            <div class="ai-tag mb-2">
                <i class="bi bi-cpu me-1"></i> AI Insights
            </div>
            <h5 class="mb-3">How your platform is performing</h5>

            <p class="mb-2">
                <span class="ai-highlight">
                    {{ $foodPostsLast7d ?? 0 }} new food posts in the last 7 days
                </span>
                and {{ $totalDonations ?? 0 }} donations have been accepted or completed so far.
            </p>

            @if(!empty($aiSummaryLines))
                <ul class="mb-2 ps-3">
                    @foreach($aiSummaryLines as $line)
                        <li class="small">{{ $line }}</li>
                    @endforeach
                </ul>
            @endif

            <p class="mb-0 small text-muted">
                These insights are generated from your current
                <strong>food posts</strong> and <strong>pickup requests</strong>.
                Later you can plug in a real AI service for deeper analysis.
            </p>
        </div>
        </div>
        </div>



        <div class="col-lg-7">
            <div class="card h-100 shadow-sm" style="border-radius:16px;">
                <div class="card-header bg-white border-0 d-flex justify-content-between align-items-center"
                     style="border-top-left-radius:16px;border-top-right-radius:16px;">
                    <div>
                        <h6 class="mb-0">Recent activity</h6>
                        <small class="text-muted">Sample layout for future donation &amp; user logs</small>
                    </div>
                    <span class="badge bg-light text-secondary">
                        <i class="bi bi-clock-history me-1"></i>Last 24 hours
                    </span>
                </div>
                <div class="card-body pt-0">
                    <div class="table-responsive">
                        <table class="table table-sm align-middle mb-0">
                            <thead class="table-light">
                            <tr>
                                <th>Time</th>
                                <th>Type</th>
                                <th>User</th>
                                <th>Status</th>
                            </tr>
                            </thead>
    <tbody>
     @forelse($recentActivities as $activity)
    <tr>
        {{-- Time --}}
        <td class="text-muted">
            {{ $activity->created_at->format('M d, H:i') }}
        </td>

        {{-- Type --}}
        <td>
            @if($activity->status === 'pending')
                <span class="badge bg-soft-secondary text-secondary">Request Pending</span>
            @elseif($activity->status === 'accepted')
                <span class="badge bg-soft-primary text-primary">Pickup Accepted</span>
            @elseif($activity->status === 'completed')
                <span class="badge bg-soft-success text-success">Pickup Completed</span>
            @else
                <span class="badge bg-soft-danger text-danger">{{ ucfirst($activity->status) }}</span>
            @endif
        </td>

        {{-- User (NGO or Donor) --}}
        <td class="text-muted">
        @if($activity->ngoUser)
             {{ $activity->ngoUser->name }}
        @elseif($activity->donor)
             {{ $activity->donor->name }}
        @else
             System
        @endif

        </td>

        {{-- Status Badge --}}
        <td>
            @if($activity->status === 'pending')
                <span class="badge bg-secondary-subtle text-secondary">Pending</span>

            @elseif($activity->status === 'accepted')
                <span class="badge bg-primary-subtle text-primary">Accepted</span>

            @elseif($activity->status === 'completed')
                <span class="badge bg-success-subtle text-success">Completed</span>

            @else
                <span class="badge bg-danger-subtle text-danger">{{ ucfirst($activity->status) }}</span>
            @endif
        </td>
    </tr>
    @empty
    <tr>
        <td colspan="4" class="text-muted small">
            No recent activity yet.
        </td>
    </tr>
    @endforelse
    </tbody>

                        </table>
                    </div>
                    <p class="small text-muted mt-2 mb-0">
                        Later you can replace this sample table with real logs of donations,
                        requests and admin actions.
                    </p>
                </div>
            </div>
        </div>
    </div>

</div>

@endsection
