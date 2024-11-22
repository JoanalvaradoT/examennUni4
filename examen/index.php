<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Light able</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" />
    <style>
      body {
        background-color: #f0f4f8;
        font-family: Arial, sans-serif;
      }
      .container {
        margin-top: 80px;
      }
      .card {
        border: none;
        border-radius: 12px;
        box-shadow: 0 4px 12px rgba(0, 0, 0, 0.1);
        padding: 2rem;
      }
      .form-label {
        color: #333;
        font-weight: 500;
      }
      .btn-primary {
        background-color: #4285f4;
        border: none;
        transition: background-color 0.3s;
      }
      .btn-primary:hover {
        background-color: #306bd8;
      }
      h1 {
        color: #4285f4;
        font-weight: bold;
        margin-bottom: 1.5rem;
      }
    </style>
</head>
<body>
    <div class="container">
      <div class="row justify-content-center">
        <div class="col-md-6">
          <div class="card">
            <h1 class="text-center">Light able</h1>
            <form method="post" id="formulario" action="/unidad4/examen/tpm/dashboard/index.php">
              <div class="mb-4">
                <label for="email" class="form-label">Correo Electronico</label>
                <input type="email" class="form-control shadow-sm" id="email" name="email" required />
              </div>
              <div class="mb-4">
                <label for="password" class="form-label">Contraseña</label>
                <input type="password" class="form-control shadow-sm" id="password" name="password" required />
              </div>
              <button type="submit" class="btn btn-primary w-100 shadow-sm">Login</button>
            </form>
          </div>
        </div>
      </div>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>