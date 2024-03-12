<template>
    <v-container fluid grid-list-xl>
        <v-row class="py-0">
            <v-col cols="12" sm="6" md="3">
                <v-sheet class="ma-6 rounded-lg">
                    <v-card class="max-auto widget-card" max-width="368" >
                        <v-card-text class="py-2">
                            <v-row no-gutters align="center">
                                <v-col cols="6">
                                    <v-card  color="blue" size="60" variant="tonal" class="text-center mt-2" style="width: 90px; height: 90px;">
                                        <v-img size="70" src="../assets/Terminal.png"/>
                                    </v-card>
                                </v-col>
                                <v-col class="text-h2 text-right text-grey-darken-3" cols="6" style="width: 140px;">{{ terminals.terminal }}</v-col>
                            </v-row>
                        </v-card-text>
                        <v-card-text class="text-right font-weight-bold text-grey-darken-1">Number of Terminal</v-card-text>
                    </v-card>
                </v-sheet>
            </v-col>
            <v-col cols="12" sm="6" md="3">
                <v-sheet class="ma-6 rounded-lg">
                    <v-card class="max-auto widget-card" max-width="368" >
                        <v-card-text class="py-2">
                            <v-row no-gutters align="center">
                                <v-col cols="6">
                                    <v-card  color="blue" size="60" variant="tonal" class="text-center mt-2" style="width: 90px; height: 90px;">
                                        <v-img size="70" src="../assets/atm.png"/>
                                    </v-card>
                                </v-col>
                                <v-col class="text-h2 text-right text-grey-darken-3" cols="6" style="width: 140px;">{{ terminals.atm }}</v-col>
                            </v-row>
                        </v-card-text>
                        <v-card-text class="text-right font-weight-bold text-grey-darken-1">ATM</v-card-text>
                    </v-card>
                </v-sheet>
            </v-col>
            <v-col cols="12" sm="6" md="3">
                <v-sheet class="ma-6 rounded-lg">
                    <v-card class="max-auto widget-card" max-width="368" >
                        <v-card-text class="py-2">
                            <v-row no-gutters align="center">
                                <v-col cols="6">
                                    <v-card  color="blue" size="60" variant="tonal" class="text-center mt-2" style="width: 90px; height: 90px;">
                                        <v-img size="70" src="../assets/crm.png"/>
                                    </v-card>
                                </v-col>
                                <v-col class="text-h2 text-right text-grey-darken-3" cols="6" style="width: 140px;">{{ terminals.crm }}</v-col>
                            </v-row>
                        </v-card-text>
                        <v-card-text class="text-right font-weight-bold text-grey-darken-1">CRM</v-card-text>
                    </v-card>
                </v-sheet>
            </v-col>
            <v-col cols="12" sm="6" md="3">
                <v-sheet class="ma-6 rounded-lg">
                    <v-card class="max-auto widget-card" max-width="368" >
                        <v-card-text class="py-2">
                            <v-row no-gutters align="center">
                                <v-col cols="6">
                                    <v-card  color="blue" size="60" variant="tonal" class="text-center mt-2" style="width: 90px; height: 90px;">
                                        <v-img size="70" src="../assets/dc.png"/>
                                    </v-card>
                                </v-col>
                                <v-col class="text-h2 text-right text-grey-darken-3" cols="6" style="width: 140px;">{{ terminals.dc }}</v-col>
                            </v-row>
                        </v-card-text>
                        <v-card-text class="text-right font-weight-bold text-grey-darken-1">DC365</v-card-text>
                    </v-card>
                </v-sheet>
            </v-col>
        </v-row>
        <v-row class="py-0">
            <v-col cols="12" sm="6" md="6">
                <v-card class="ma-6 rounded-lg"  style="width: 500px; height: 400px">
                    <PieChart/>
                    <!-- <BarChart/> -->
                </v-card>
            </v-col>
        </v-row>
    </v-container>
</template>
<script>
import axios from 'axios';
import PieChart from '../Components/chart/PieChart.vue'
import BarChart from '../Components/chart/BarChart.vue'
export default {
    name: 'dashbord',
    components: {
        PieChart,
        BarChart,
    },
  data: () => ({
    terminals: [],
  }),
  mounted() {
    axios.get('/api/IMS/terminal/countTerminal')
                .then(response => {
                    this.terminals = response.data;
                    console.log("machine", this.terminals);
                })
                .catch(error => {
                    console.log(error);
                })
  },
  methods: {

  },
}
</script>

<style scoped>
/* .pieChart {
    height: 500px;
    margin-top: 20px;
    width: 30%;
} */
</style>

