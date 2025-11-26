<div>
    <x-componens-personalizados.tabla-datos>
        @slot('columnas')
            @foreach ($columnas as $columna)
                <th>{{ $columna }}</th>
            @endforeach
        @endslot

        @slot('filas')
            @foreach ($datos as $dato)
                <tr>
                    @foreach ($filas as $fila)
                        <td>
                            {{ $dato->$fila }}
                        </td>
                    @endforeach
                </tr>
            @endforeach
        @endslot
    </x-componens-personalizados.tabla-datos>
</div>
