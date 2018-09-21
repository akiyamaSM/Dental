    <table id ="myTable" class="table table-hover table-striped">
        <thead>
        <tr>
            <th class="text-center">Code</th>
            <th class="text-center">Remarque</th>
            <th class="text-center">Date de Seance</th>
        </tr>
        </thead>
        <tbody>
        @foreach($operation->sessions as $session )
            <tr>
                <td class="text-center">{{ $session->id }}</td>
                <td class="text-center">{{ $session->notice }}</td>
                <td class="text-center">{{ $session->created_at->format('Y-m-d H:i') }}</td>
            </tr>
        @endforeach
        </tbody>
    </table>
