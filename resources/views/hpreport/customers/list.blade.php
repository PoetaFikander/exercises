@extends('hpreport.index')

@section('hprcontent')

    <table class="table table-striped table-hover">
        <thead>
        <tr class="table-dark">
            <th scope="col">Kod</th>
            <th scope="col">Nazwa</th>
            <th scope="col">NIP</th>
        </tr>
        </thead>
        <tbody>

        @foreach($customers as $customer)
            <tr
                data-toggle="customershow"
                data-id="{{ $customer->altum_id }}"
            >
                <td class="text-nowrap">{{ $customer->code }}</td>
                <td>{{ $customer->name }}</td>
                <td>{{ $customer->tin }}</td>
            </tr>
        @endforeach

        </tbody>
    </table>

@endsection

