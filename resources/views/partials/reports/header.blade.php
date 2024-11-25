{{-- START HEADER --}}
<header style="position: fixed;">
    <div style="height: 100px;">
        <table style="width: 100%;">
            <tbody>
                <tr>
                    <td style="height: 100px; vertical-align: middle; width: 10%;">
                        <img src="{{ asset('img/brasao.png') }}" style="width: 100px; height: 100px;">
                    </td>
                    <td style="height: 64px; width: 50%;">
                        <table>
                            <tbody>
                                <tr>
                                    <td style="font-size: 18px; font-weight: bold;">{{ $title }}</td>
                                </tr>
                                <tr>
                                    <td style="font-size: 14px; font-weight: bold;">{{ session('clientName') }}</td>
                                </tr>
                                <tr>
                                    <td style="font-size: 12px; padding-top: 10px;">
                                        <span style="font-weight: bold;">CNPJ:</span> {{ session('clientCnpj') }}
                                    </td>
                                </tr>
                                <tr>
                                    <td style="font-size: 12px;">
                                        <span style="font-weight: bold;">Emissor:</span> {{ session('municipeName') }}
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    </td>
                    <td style="height: 64px; text-align: right;">
                        <table style="width: 100%">
                            <tbody>
                                <tr>
                                    <td style="height: 50px; text-align: right;">
                                    {{-- <img src="https://api.qrserver.com/v1/create-qr-code/?size=150x150&data={{URL::to('/')}}"
                                            alt="qrCode" style="width: 60px; height: 60px;"> --}}
                                    </td>
                                </tr>

                                <tr>
                                    <td
                                        style="font-size: 12px; height: 10px; text-align: right; vertical-align: bottom;">
                                        <span style="font-weight: bold;">Emissão:</span> {{ date('d/m/Y \à\s H:i:s') }}
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    </td>
                </tr>
            </tbody>
        </table>
    </div>
    <hr style="margin-top: 5px;" />
</header>
{{-- END HEADER --}}