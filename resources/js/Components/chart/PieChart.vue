<template>
    <div class="ma-2 text-grey-darken-3">
        <h3>Bank</h3>
    </div>
    <div class="ma-4 ml-12" style="width: 300px;">
        <Pie v-if="loaded" :data="chartData" :options="chartOptions"/>
    </div>
</template>

<script>
  import { Pie } from 'vue-chartjs'
  import {
    Chart as ChartJS,
    Title,
    Tooltip,
    Legend,
    ArcElement,
    CategoryScale
  } from 'chart.js'

  ChartJS.register(Title, Tooltip, Legend, ArcElement, CategoryScale)

  export default {
    name: 'PieChart',
    components: {
      Pie
    },

    data() {
      return {
        loaded: false,
        chartData: null,
        chartOptions: {
          responsive: true,
          maintainAspectRatio: false,
        }
      }
    },
    mounted () {
        this.loaded = false
        axios.get('/api/pieChart')
                .then(response => {
                    // this.chartData = response.data;
                    const { amk, wing, aba } = response.data;
                    this.chartData = {
                        labels: ['AMK', 'Wing', 'ABA'],
                        datasets: [
                            {
                                label: 'Terminal',
                                backgroundColor: ['#FF1493', '#00FF00', '#0000FF'],
                                data: [amk, wing, aba],
                            }
                        ]
                    };

        this.loaded = true;
                    console.log(this.chartData);
                })
                .catch(error => {
                    console.log(error);
                })
    },
  }
  </script>


