<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>FixIt - Maintenance Request Tracker</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.6.0/dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style>
        .hero {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            color: white;
            padding: 100px 0;
            text-align: center;
        }
        .feature-card {
            padding: 30px;
            border-radius: 10px;
            box-shadow: 0 4px 6px rgba(0,0,0,0.1);
            margin-bottom: 30px;
            height: 100%;
        }
        .feature-icon {
            font-size: 3rem;
            color: #667eea;
            margin-bottom: 20px;
        }
    </style>
</head>
<body>
    <!-- Navigation -->
    <nav class="navbar navbar-expand-lg navbar-light bg-light">
        <div class="container">
            <a class="navbar-brand" href="/">
                <i class="fas fa-wrench"></i> FixIt
            </a>
            <div class="ml-auto">
                @auth
                    <a href="{{ route('dashboard') }}" class="btn btn-primary">Dashboard</a>
                @else
                    <a href="{{ route('login') }}" class="btn btn-outline-primary mr-2">Login</a>
                    <a href="{{ route('register') }}" class="btn btn-primary">Register</a>
                @endauth
            </div>
        </div>
    </nav>

    <!-- Hero Section -->
    <section class="hero">
        <div class="container">
            <h1 class="display-4 font-weight-bold mb-4">Welcome to FixIt</h1>
            <p class="lead mb-5">Your Complete Maintenance & Service Request Management Solution</p>
            @guest
            <a href="{{ route('register') }}" class="btn btn-light btn-lg mr-3">
                <i class="fas fa-user-plus"></i> Get Started
            </a>
            <a href="{{ route('login') }}" class="btn btn-outline-light btn-lg">
                <i class="fas fa-sign-in-alt"></i> Sign In
            </a>
            @else
            <a href="{{ route('dashboard') }}" class="btn btn-light btn-lg">
                <i class="fas fa-tachometer-alt"></i> Go to Dashboard
            </a>
            @endguest
        </div>
    </section>

    <!-- Features Section -->
    <section class="py-5">
        <div class="container">
            <h2 class="text-center mb-5">Why Choose FixIt?</h2>
            <div class="row">
                <div class="col-md-4">
                    <div class="feature-card text-center">
                        <div class="feature-icon">
                            <i class="fas fa-bolt"></i>
                        </div>
                        <h4>Fast Request Submission</h4>
                        <p>Submit maintenance requests quickly with image and video attachments. Our AI helps categorize your requests automatically.</p>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="feature-card text-center">
                        <div class="feature-icon">
                            <i class="fas fa-users-cog"></i>
                        </div>
                        <h4>Efficient Assignment</h4>
                        <p>Admins can assign requests to the right technicians based on their skills and availability in seconds.</p>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="feature-card text-center">
                        <div class="feature-icon">
                            <i class="fas fa-chart-line"></i>
                        </div>
                        <h4>Real-time Tracking</h4>
                        <p>Track the status of your requests in real-time. Get email notifications when status changes.</p>
                    </div>
                </div>
            </div>

            <div class="row mt-4">
                <div class="col-md-4">
                    <div class="feature-card text-center">
                        <div class="feature-icon">
                            <i class="fas fa-robot"></i>
                        </div>
                        <h4>AI-Powered</h4>
                        <p>Smart categorization and quick reply suggestions help you get faster solutions to common problems.</p>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="feature-card text-center">
                        <div class="feature-icon">
                            <i class="fas fa-bell"></i>
                        </div>
                        <h4>Email Notifications</h4>
                        <p>Stay informed with automatic email notifications for status updates on your service requests.</p>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="feature-card text-center">
                        <div class="feature-icon">
                            <i class="fas fa-clipboard-check"></i>
                        </div>
                        <h4>Complete Management</h4>
                        <p>Manage IT, plumbing, electrical, and other maintenance requests all in one place.</p>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- CTA Section -->
    <section class="bg-light py-5">
        <div class="container text-center">
            <h2 class="mb-4">Ready to streamline your maintenance requests?</h2>
            @guest
            <a href="{{ route('register') }}" class="btn btn-primary btn-lg">
                <i class="fas fa-rocket"></i> Start Using FixIt Now
            </a>
            @else
            <a href="{{ route('service-requests.create') }}" class="btn btn-primary btn-lg">
                <i class="fas fa-plus-circle"></i> Create Your First Request
            </a>
            @endguest
        </div>
    </section>

    <!-- Footer -->
    <footer class="bg-dark text-white py-4 mt-5">
        <div class="container text-center">
            <p class="mb-0">&copy; 2024 FixIt. All rights reserved.</p>
            <p class="mb-0"><small>Maintenance Request Tracker v1.0</small></p>
        </div>
    </footer>
</body>
</html>