<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <title>Historique des maintenances</title>
    <style>
        body {
            font-family: sans-serif;
            font-size: 12px;
            color: #000;
            background: #fff;
            margin: 0;
            padding: 0;
        }

        h1 {
            font-size: 18px;
            font-weight: bold;
            margin-bottom: 12px;
        }

        h2 {
            font-size: 14px;
            font-weight: bold;
            margin-bottom: 8px;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 12px;
        }

        th,
        td {
            border: 1px solid #000;
            padding: 6px;
            text-align: left;
            vertical-align: top;
        }

        th {
            font-weight: bold;
        }

        ul {
            margin: 0;
            padding-left: 16px;
        }

        li {
            margin-bottom: 2px;
        }
    </style>
</head>

<body>
    <h1>Historique des maintenances</h1>

    @if($start_date || $end_date)
        <h2>
            Filtré
            @if($start_date) Du {{ $start_date }} @endif
            @if($end_date) au {{ $end_date }} @endif
        </h2>
    @else
        <h2>Toutes les maintenances</h2>
    @endif

    <table>
        <thead>
            <tr>
                <th>Date Planifiée</th>
                <th>Type</th>
                <th>Détails Maintenance</th>
                <th>Technicien</th>
                <th>Statut</th>
            </tr>
        </thead>
        <tbody>
            @forelse($maintenances as $maintenance)
                <tr>
                    <td>{{ $maintenance->date_planifiee->format('d/m/Y') }}</td>
                    <td>{{ $maintenance->type }}</td>
                    <td>{{ $maintenance->description }}</td>
                    <td>
                        @if($maintenance->technicien)
                            {{ $maintenance->technicien->name }}
                        @else
                            N/A
                        @endif
                    </td>
                    <td>{{ $maintenance->statut }}</td>
                </tr>
            @empty
                <tr>
                    <td colspan="4" style="text-align: center;">Aucune maintenance trouvée</td>
                </tr>
            @endforelse
        </tbody>
    </table>
</body>

</html>