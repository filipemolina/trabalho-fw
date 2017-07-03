<!-- Chart.js -->
    <script src="{{ asset('vendors/Chart.js/dist/Chart.min.js') }}"></script>
    <!-- gauge.js -->
    <script src="{{ asset('vendors/gauge.js/dist/gauge.min.js') }}"></script>
    <!-- Skycons -->
    <script src="{{ asset('vendors/skycons/skycons.js') }}"></script>
    <!-- Flot -->
    <script src="{{ asset('vendors/Flot/jquery.flot.js') }}"></script>
    <script src="{{ asset('vendors/Flot/jquery.flot.pie.js') }}"></script>
    <script src="{{ asset('vendors/Flot/jquery.flot.time.js') }}"></script>
    <script src="{{ asset('vendors/Flot/jquery.flot.stack.js') }}"></script>
    <script src="{{ asset('vendors/Flot/jquery.flot.resize.js') }}"></script>
    <!-- Flot plugins -->
    <script src="{{ asset('vendors/flot.orderbars/js/jquery.flot.orderBars.js') }}"></script>
    <script src="{{ asset('vendors/flot-spline/js/jquery.flot.spline.min.js') }}"></script>
    <script src="{{ asset('vendors/flot.curvedlines/curvedLines.js') }}"></script>
    <!-- DateJS -->
    <script src="{{ asset('vendors/DateJS/build/date.js') }}"></script>
    <!-- bootstrap-progressbar -->
    <script src="{{ asset('vendors/bootstrap-progressbar/bootstrap-progressbar.min.js') }}"></script>


    <script>

        $(function(){

            @include('includes.home.chart_config')

            /////////////////////////// Donut

            var options = {
              legend: false,
              responsive: false
            };

            new Chart(document.getElementById("canvas1"), {
              type: 'doughnut',
              tooltipFillColor: "rgba(51, 51, 51, 0.55)",
              data: {
                labels: [
                  @foreach($resultados['bairros']['nomes'] as $bairro)

                    "{{ $bairro }}",

                  @endforeach
                ],
                datasets: [{
                  data: [
                    @foreach($resultados['bairros']['nomes'] as $bairro)

                        "{{ $resultados['bairros'][$bairro]['porcentagem'] }}",

                    @endforeach
                    ],
                  backgroundColor: [
                    @foreach($resultados['bairros']['nomes'] as $bairro)

                        "{{ $resultados['bairros'][$bairro]['cor'] }}",

                    @endforeach
                  ],
                }]
              },
              options: options
            });

            /////////////////////////// Donut

            /////////////////////////// Barras

            var ctx = document.getElementById("mybarChart");
            var mybarChart = new Chart(ctx, {
              type: 'bar',
              data: {
                labels: [
                  
                    @foreach($areas as $area)

                        `{{ $area['nome'] }}`,

                    @endforeach

                ],
                datasets: [{
                  label: 'Homens',
                  backgroundColor: "#6cd2e9",
                  data: [

                      @foreach($areas as $area)

                          {{ $area['homens'] }},

                      @endforeach

                  ]
                }, {
                  label: 'Mulheres',
                  backgroundColor: "#c83ac3",
                  data: [

                      @foreach($areas as $area)

                          {{ $area['mulheres'] }},

                      @endforeach

                  ]
                }]
              },

              options: {
                scales: {
                  yAxes: [{
                    ticks: {
                      beginAtZero: true
                    }
                  }]
                }
              }
            });

            /////////////////////////// Barras

        });
        
    </script>
