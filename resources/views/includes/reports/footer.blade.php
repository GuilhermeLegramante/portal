{{-- START FOOTER --}}
<footer>
    <div style="border-top: 1px solid #000000; height: 30px; margin-top: 5px; position: fixed; bottom: 5px;">
        <table style="width: 100%;">
            <tbody style="font-size: 8pt;">
                <tr>
                    <td>
                        <span style="font-weight: bold;">{{env('APP_CONTRACHEQUE_NAME')}}</span> -
                        {{ ucwords(strtolower(session('clientName'))) }}
                    </td>
                </tr>
                <tr>
                    <td>
                        <span style="font-weight: bold;">Fonte:</span> {{ URL::to('/') }}
                    </td>
                </tr>
            </tbody>
        </table>
    </div>
</footer>
{{-- END FOOTER --}}