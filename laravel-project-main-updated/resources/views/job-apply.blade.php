<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="Attendance Form">
    <title>Apply Job</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/5.3.3/css/bootstrap.min.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>
</head>
<body>
    <div class="container mt-5">
        <div class="card shadow-sm border-0">
            <div class="card-body p-4">
                <h3 class="card-title text-center mb-4">Apply Job</h3>
                <form method="POST" action="{{ url('/apply') }}" enctype="multipart/form-data" class="forms-sample" id="employeeForm">
                @csrf
                    <div class="row mb-3">
                        <div class="col-md-6">
                            <label for="name" class="form-label">Name</label>
                            <input type="text" class="form-control" id="name" name="name">
                        </div>
                        <div class="col-md-6">
                            <label for="email" class="form-label">Email</label>
                            <input type="email" class="form-control" id="email" name="email">
                        </div>
                    </div>
                    <div class="row mb-3">
                        <div class="col-md-6">
                            <label for="mobile" class="form-label">Mobile</label>
                            <input type="tel" class="form-control" id="mobile" name="mobile">
                        </div>
                        <div class="col-md-6">
                            <label for="applied_for" class="form-label">Applied For</label>
                            <input type="text" class="form-control" id="applied_for" name="applied_for">
                        </div>
                    </div>
                    <div class="row mb-3">
                        <div class="col-md-6">
                            <label for="applied_date" class="form-label">Applied Date</label>
                            <input type="date" class="form-control" id="applied_date" name="applied_date" readonly>
                        </div>

                        <script>
                            // Set current date in YYYY-MM-DD format
                            const today = new Date().toISOString().split('T')[0];
                            document.getElementById('applied_date').value = today;
                        </script>
                        <div class="col-md-6">
                            <label for="resume" class="form-label">Resume</label>
                            <input type="file" class="form-control" id="resume" name="resume">
                        </div>
                    </div>
                    <div class="text-end">
                        <button type="submit" class="btn btn-primary">Save Changes</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/5.3.3/js/bootstrap.bundle.min.js"></script>
</body>
</html>
