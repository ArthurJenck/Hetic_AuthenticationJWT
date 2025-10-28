<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard - JWT Auth</title>
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            min-height: 100vh;
            padding: 20px;
        }

        .container {
            max-width: 800px;
            margin: 50px auto;
            background: white;
            border-radius: 20px;
            padding: 40px;
            box-shadow: 0 20px 60px rgba(0, 0, 0, 0.3);
            animation: fadeIn 0.5s ease-in;
        }

        @keyframes fadeIn {
            from {
                opacity: 0;
                transform: translateY(-20px);
            }

            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        .header {
            text-align: center;
            margin-bottom: 40px;
        }

        h1 {
            color: #333;
            font-size: 2.5em;
            margin-bottom: 10px;
        }

        .token-box {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            color: white;
            padding: 25px;
            border-radius: 15px;
            margin: 30px 0;
            box-shadow: 0 10px 30px rgba(102, 126, 234, 0.3);
        }

        .token-label {
            font-weight: bold;
            font-size: 0.9em;
            margin-bottom: 10px;
            opacity: 0.9;
        }

        .token-value {
            font-family: 'Courier New', monospace;
            font-size: 0.85em;
            word-break: break-all;
            background: rgba(255, 255, 255, 0.2);
            padding: 15px;
            border-radius: 10px;
            line-height: 1.6;
        }

        .warning {
            background: #fff3cd;
            color: #856404;
            padding: 15px 20px;
            border-radius: 10px;
            border-left: 4px solid #ffc107;
            margin: 20px 0;
        }

        .stats {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
            gap: 20px;
            margin: 30px 0;
        }

        .stat-card {
            background: #f8f9fa;
            padding: 20px;
            border-radius: 15px;
            text-align: center;
            border: 2px solid #e9ecef;
        }

        .stat-card .value {
            font-size: 1.5em;
            font-weight: bold;
            color: #667eea;
            margin-bottom: 5px;
        }

        .stat-card .label {
            color: #666;
            font-size: 0.9em;
        }

        .btn {
            display: inline-block;
            padding: 12px 30px;
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            color: white;
            text-decoration: none;
            border-radius: 50px;
            font-weight: bold;
            transition: all 0.3s ease;
            box-shadow: 0 4px 15px rgba(102, 126, 234, 0.4);
            margin: 10px 5px;
        }

        .btn:hover {
            transform: translateY(-2px);
            box-shadow: 0 6px 20px rgba(102, 126, 234, 0.6);
        }

        .actions {
            text-align: center;
            margin-top: 30px;
        }

        .error-container {
            text-align: center;
            padding: 60px 40px;
        }

        .error-container h1 {
            color: #e74c3c;
            margin-bottom: 15px;
        }

        .error-container p {
            color: #666;
            margin-bottom: 30px;
            font-size: 1.1em;
        }
    </style>
</head>

<body>
    <?php
    if (isset($_COOKIE["token"])) :
    ?>
        <div class="container">
            <div class="header">
                <h1>Tableau de bord</h1>
            </div>

            <div class="stats">
                <div class="stat-card">
                    <div class="value">Actif</div>
                    <div class="label">Statut</div>
                </div>
                <div class="stat-card">
                    <div class="value">10s</div>
                    <div class="label">Durée du token</div>
                </div>
                <div class="stat-card">
                    <div class="value">JWT</div>
                    <div class="label">Type d'auth</div>
                </div>
            </div>

            <div class="warning">
                Ce token est valide 10 secondes
            </div>

            <div class="token-box">
                <div class="token-label">Token :</div>
                <div class="token-value"><?php echo htmlspecialchars($_COOKIE["token"]); ?></div>
            </div>

            <div class="actions">
                <a href="../" class="btn">Accueil</a>
                <a href="../login/" class="btn">Reconnecter</a>
            </div>
        </div>

    <?php else : ?>

        <div class="container">
            <div class="error-container">
                <h1>401 Unauthorized</h1>
                <p>Vous n'avez pas la permission d'accéder à cette page.</p>
                <a href="../login/" class="btn">Se connecter</a>
                <a href="../" class="btn">Accueil</a>
            </div>
        </div>

    <?php endif; ?>
</body>

</html>