<script>
import { HomeNavbar, useRouter,  $toast, defineComponent, BackButton ,ref } from '@/plugins/global.js'



  export default defineComponent({  
    //Component yang digunakan
    components:{
      HomeNavbar,
      BackButton
    },
    
    data(){
        return{
            router : useRouter(),
            dataLaporan: ref([]),
            countInit : 0,
            currentDate : null,
            test:'mantap',
            selectedYear: null,
            months: [
                "Januari", "Februari", "Maret", "April", "Mei", "Juni",
                "Juli", "Agustus", "September", "Oktober", "November", "Desember"
            ],
            YearList : [],
            chart : null,
            table : null,
        }
    },

    methods :{
        DataTableFeatures() {
            $(document).ready(() => {
                var selectedYear = this.getMonthName(this.selectedYear);
                var currentDate = this.currentDate;
                const container = this.$refs.chartContainer;
                console.log(container);

                this.table = $('#example').DataTable({
                dom: 'pfrtip',
                paging: false,
                ordering: false,
                buttons: [
                    {
                    extend: 'print',
                    text: 'Print',
                    title: '',
                    message: `<strong>Gofit</strong>
                                </br>
                                <p>Jl CentralPark No. 10 Yogyakarta</p>
                                </br>
                                <strong><u>Laporan Aktivitas Kelas Bulanan</u></strong>
                                </br>
                                <p><u>Tahun: 2023</u></p>
                                <p>Tanggal Cetak : ${currentDate} </p>
                                <div id="chartContainer">${container.innerHTML}</div>`,
                    },
                ],
                });

                // Declare chart variable
                

                // On each draw, update the data in the chart
                this.table.on('draw', () => {
                this.updateChart();
            });


                let chartContainer = document.getElementById('chartContainer');
                if (!chartContainer) {
                chartContainer = document.createElement('div');
                chartContainer.id = 'chartContainer';
                container.parentNode.insertBefore(chartContainer, container.nextSibling);
                }

                // Create the chart with initial data
                this.chart = Highcharts.chart(container, {
                chart: {
                    type: 'column',
                },
                title: {
                    text: 'Grafik Pendapatan Perbulan',
                },
                xAxis: {
                    categories: this.chartCategories(this.table),
                    labels: {
                    rotation: 0, // Mengatur rotasi label menjadi 0 derajat (horizontal)
                    },
                },
                yAxis: {
                    title: {
                    text: 'Pendapatan(M = Million)',
                    },
                },
                plotOptions: {
                    bar: {
                    dataLabels: {
                        enabled: true,
                        inside: true,
                        align: 'center',
                        verticalAlign: 'bottom',
                        style: {
                        fontSize: '10px',
                        },
                    },
                    },
                },
                series: [
                    {
                    data: this.chartData(this.table),
                    },
                ],
                });

            });

            console.log(this.table);
},

chartCategories(table) {
    const categories = [];

    table.column(0).data().each((val) => {
        categories.push(val);
    });
    return categories;
},

chartData(table) {
    const data = [];

    table.column(3).data().each((val) => {
        data.push(parseFloat(val));
    });

    return data;
},
    
        async getDataTahunan(message,year= null){
            const selectedYearLocal  = this.YearList[year-1];
            const url = "/laporanpendapatantahunan";
            const params = (year != null) ? { year : selectedYearLocal } : {};
            this.currentDate =  this.getCurrentDateTime();
            const request = await this.$http.get(url, {params : params})
            this.dataLaporan = request.data.data
            if(this.countInit == 0){
                this.DataTableFeatures()
                    this.countInit++;
            }else{
                this.uppdateTableData();
                this.updateChart();
            }
            // {
            //     $toast.success(message)
                
            // }else{
            // }
        },

        uppdateTableData() {
        const data = Object.entries(this.dataLaporan).map(([key, value]) => {
            return Object.values(value);
        });
        this.table.clear().rows.add(data).draw();
        console.log(this.table.data());
        },
        updateChart() {
            const newData = this.chartData(this.table);
            const categories = this.chartCategories(this.table);
            // console.log(newData);
            // console.log(newData);
    
            this.chart.xAxis[0].setCategories(categories);
            this.chart.series[0].setData(newData);
        },


        getCurrentDateTime() {
            const now = new Date();
            const date = now.getDate();
            const month = now.getMonth() + 1; // Perhatikan penambahan 1 karena indeks bulan dimulai dari 0
            const year = now.getFullYear();

            const formattedDate = this.addLeadingZero(date) + "/" + this.addLeadingZero(month) + "/" + year;
            const dateTime = formattedDate ;
            
            return dateTime;
            },

            // Fungsi untuk menambahkan angka 0 di depan angka satu digit (0-9)
            addLeadingZero(number) {
            return (number < 10 ? "0" : "") + number;
            },

            getMonth(){
                const now = new Date();
                const month = now.getMonth() + 1; // Perhatikan penambahan 1 karena indeks bulan dimulai dari 0
                return month;
            },

            cetakData(){
                window.print();
            },

            getMonthName(month) {
            const monthNames = [
                "Januari", "Februari", "Maret", "April", "Mei", "Juni",
                "Juli", "Agustus", "September", "Oktober", "November", "Desember"
            ];
            return monthNames[month - 1];
            },

            printData() {
            // Mendapatkan konten tabel yang akan dicetak
            const tableContent = $('#example').html();

            // Menggabungkan konten tabel dengan konten grafik Highcharts
            const contentToPrint = `
                <strong>Gofit</strong>
                    </br>
                    <p>Jl CentralPark No. 10 Yogyakarta</p>
                    </br>
                    <strong><u>Laporan Aktivitas Kelas Bulanan</u></strong>
                    </br>
                    <p><u>Bulan : ${this.getMonthName(this.selectedMonth)} Tahun: 2023</u></p>
                    <p>Tanggal Cetak : ${this.currentDate} </p>
                    <table>${tableContent}</table>
                    <div id="container">${$('#container').html()}</div>
                `;

                // Membuka jendela baru untuk mencetak konten
                const printWindow = window.open('', '', 'width=800,height=600');
                printWindow.document.open();
                printWindow.document.write(`
                <html>
                <head>
                    <title>Cetak Laporan</title>
                    <style>
                    /* Gaya khusus untuk mencetak */
                    @media print {
                        /* Gaya untuk menyembunyikan elemen yang tidak perlu dicetak */
                
                        #container, #example {
                        visibility: visible;
                        }
                        /* Gaya khusus lainnya sesuai kebutuhan Anda */
                    }
                    </style>
                </head>
                <body>
                    ${contentToPrint}
                </body>
                </html>
                `);
                    printWindow.document.close();

                // console.log(printWindow);
                // Tunggu beberapa saat sebelum mencetak untuk memastikan konten dimuat
                setTimeout(() => {
                printWindow.print();
                printWindow.close();
                }, 500);
            },
        getYearList(){
            const year = new Date().getFullYear();
            for(var i = year -4; i<=year ; i++){
                this.YearList.push(i)
            }
        }


    },
    async mounted(){
        this.selectedYear = this.getMonth();
        await this.getDataTahunan('Berhasil Mengambil Data  Laporan Tahunan Gym' ,this.selectedYear );
        console.log(this.selectedYear);
        this.getYearList();
        console.log(this.YearList);
    },

    computed: {
  totalRowCount() {
    return this.dataLaporan.reduce((total, row) => total + row.total_pendapatan, 0);
  }
}

})
</script>
<template >
  <header>
    <home-navbar :message="'Gofit - Laporan Pendapatan Bulanan / Tahun'"></home-navbar>
  </header>
  <main>
    <!--TODO Ubah jadi pilih tahun   -->
    <div class="container mt-5">
        <label for="bulan">Pilih Tahun:</label>
            <select id="bulan" v-model="selectedYear">
                <option v-for="(tahun, index) in YearList" :key="index" :value="index+1">{{ tahun }}</option>
            </select>
        <button class="btn btn-primary m-2" @click="getDataTahunan('Ambil Kembali Data',selectedYear)">Ambil Data</button>
    </div>
      <div class="text-dark table-custom mt-5 ms-5 me-5 p-2 d-inline-block">
        <!-- <bu class="btn btn-primary">Presensi Gym</bu   tton> -->
      </div>
      <div class="content bg-white text-dark table-custom m-5 mt-2">
          <div  class="container-fluid  p-4">
              <h3 >Tabel Laporan Tahunan</h3>
              <button class="btn btn-primary m-3" @click="printData">Cetak Laporan</button>
              <table id="example" class="#example table table-striped filters" style="width:100%;">
                <thead>
                    <tr>
                        <th>Bulan</th>
                        <th>Aktivasi</th>
                        <th>Deposit</th>
                        <th>Total</th>
                    </tr>
                </thead>
                <tbody>
                    <tr v-for="(row,key) in dataLaporan" :key="key">
                        <td>{{row.nama_bulan}}</td>
                        <td>{{row.total_pendapatan_aktivasi}}</td>
                        <td>{{row.total_pendapatan_deposit}}</td>
                        <td>{{row.total_pendapatan}}</td>
                    </tr>
                    <tr>
                        <td><strong>TOTAL</strong></td>
                        <td></td>
                        <td></td>
                        <td>{{totalRowCount }}</td>
                    </tr>
                </tbody>
            </table>
            <div id="container" ref="chartContainer"></div>
            <div class="row">
                <back-button class="col-md-3" className="btn btn-dark"></back-button>
            </div>
        </div>
  </div>
  </main>
</template>



<style scoped>
    .table-custom{
        border-radius: 10px;
    }


    .title.active {
        background-color: #e6e6e6;
    }
    
    .title:hover {
        background-color: #f2f2f2;
    }


    #container {
        width: 100%;
        height: 400px; /* Sesuaikan dengan ukuran yang Anda inginkan */
    }

</style>
