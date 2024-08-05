<template>

				<div>
					<component :is="header"></component>
					<slot/>

					<div id="kt_content_container" class="d-flex flex-column-fluid align-items-start container-xxl">
						<!--begin::Post-->
						<div class="content flex-row-fluid" id="kt_content">
							<!--begin::Billing History-->
							<div class="card">
								<!--begin::Card header-->
								<div class="card-header card-header-stretch border-bottom border-gray-200">
									<!--begin::Title-->
									<div class="card-title">
										<h3 v-if="statement.list.success === false" class="fw-bolder m-0">My Statement <span class="text-gray-600">(0 found)</span></h3>
										<h3 v-if="!isFetchingStatement" class="fw-bolder m-0">My Statement 
                                            <span class="text-danger">{{ statement.type!=='' ? ' - '+statement.type : '' }} 
                                                <span class="fs-7 text-gray-900 fw-bold" v-if="statement.list.staTransTime">({{ moment(statement.list.staTransTime).format("MMM DD, YYYY [at] h:mm a") }} - {{ moment(statement.list.endTransTime).format("MMM DD, YYYY [at] h:mm a") }})</span>
                                            </span>
                                        </h3>
										<h3 v-if="isFetchingStatement" class="fw-bolder m-0 text-gray-500">My Statement...</h3>
									</div>
									<!--end::Title-->
									<!--begin::Toolbar-->
									<div class="card-toolbar m-0">
                                        <Datepicker class="mt-5" v-model="statementDate" range locale="ke"></Datepicker> &nbsp; &nbsp;
                                        <!--begin::Select-->
                                        <select @change="getStatement" v-model="statement.type" class="me-3 mt-5 h-35px">
                                            <option disabled value="">Select Statement Type</option>
                                            <option value="MTC">MTC Cards</option>
                                            <option value="ETC">ETC Installations</option>
                                        </select>
                                        <!--end::Select-->
                                        <button @click="getStatement" class="btn btn-sm btn-light-info me-3 mt-5 h-35px">
                                            <span v-if="!isFetchingStatement">Get Statement</span>
                                            <span v-if="isFetchingStatement">Please wait ... <span class="spinner-border spinner-border-sm align-middle fw-bold"></span></span>
                                        </button>
                                        <button @click="exportToCsv" class="btn btn-sm btn-light-success me-3 mt-5 h-35px">
                                            <span v-if="!isExporting"><i class="fa fa-download"></i></span>
                                            <span v-if="isExporting"><span class="spinner-border spinner-border-sm align-middle fw-bold"></span></span>
                                        </button>
									</div>
									<!--end::Toolbar-->
								</div>
								<!--end::Card header-->

                                <!--begin::Table container-->
                                <div class="table-responsive">
                                    <!--begin::Table-->
                                    <table class="table table-row-bordered align-middle gy-4 gs-9">
                                        <thead class="border-bottom border-gray-200 fs-6 text-gray-600 fw-bolder bg-light bg-opacity-75">
                                            <tr>
                                                <td class="">Amount</td>
                                                <td class="">Balance Before</td>
                                                <td class="">Balance After</td>
                                                <td class="">Transaction Type</td>
                                                <td class="">Date</td>
                                            </tr>
                                        </thead>
                                        <tbody class="fw-bold text-gray-600">
                                            <!--begin::Table row-->
                                            <tr v-if="statement.list === '' && !isFetchingStatement"><td class="text-center" colspan="8">No records to display.</td></tr>
                                            <tr v-if="isFetchingStatement"><td class="text-center" colspan="8">Fetching statement... <span class="spinner-border spinner-border-sm align-middle text-gray-600 mr-2"></span></td></tr>
                                            <!--end::Table row-->
                                            <!--begin::Table row-->
                                            <tr v-for="entry in statement.list.dataList" :key="entry.id">
                                                <td>{{ Math.round(entry.amount).toString().replace(/\B(?=(\d{3})+(?!\d))/g, ",") }} Points</td>
                                                <td>{{ Math.round(entry.preBalance).toString().replace(/\B(?=(\d{3})+(?!\d))/g, ",") }} </td>
                                                <td>{{ Math.round(entry.afterBalance).toString().replace(/\B(?=(\d{3})+(?!\d))/g, ",") }} </td>
                                                <td>
                                                    <span :class="entry.operationType === 1 ? 'badge-light-primary' : 'badge-light-info'" class="me-1 badge">{{ entry.operationType == 1 ? 'Account Top Up' : 'Toll Payment' }}</span>
                                                    <span v-if="entry.operationType === 2" class="me-1 badge badge-light-dark">{{ entry.enStationId ? entry.enStationId+' -- ' : '' }} {{ entry.exStationId }}</span>
                                                    <span v-if="entry.cardNo" class="me-1 badge badge-light-success">Card No: {{ entry.cardNo }}</span>
                                                    <span v-if="entry.OBUNO" class="me-1 badge badge-light-success">OBU No: {{ entry.OBUNO }}</span>
                                                </td>
                                                <td>{{ moment(entry.transTime).format("MMM DD, YYYY [at] h:mm a") }} </td>
                                            </tr>
                                            <!--end::Table row-->
                                        </tbody>
                                    </table>
                                    <!--end::Table-->
                                </div>
                                <!--end::Table container-->

							</div>
							<!--end::Billing Address-->
						</div>
						<!--end::Post-->
					</div>

					<component :is="footer"></component>
					<slot/>
                </div>


</template>

<script setup>
import { computed, ref, onMounted, reactive } from 'vue'
import Header from './include_files/HeaderLoggedIn';
import Footer from './include_files/Footer';
import {useStore} from "vuex";
import { useRouter } from 'vue-router'
import moment from 'moment'
import Datepicker from '@vuepic/vue-datepicker';
import '@vuepic/vue-datepicker/dist/main.css'
const router = useRouter()
const store = useStore()

const statementDate = ref('');
// const consumptionStatement = computed(() => '');
const isFetchingStatement = ref(false);
const isExporting = ref(false);
let errorMessage = ref('')
let errors = ref({})

onMounted(() => {
    // const endDate = new Date();
    // const startDate = new Date(new Date().setDate(startDate.getDate() - 14));
    // date.value = [startDate, endDate];
    // store.dispatch('user/fetchUsers')
    // store.dispatch('user/cardRechAndConsump')
    // store.dispatch('user/obuRechAndConsump')
})

const statement = reactive({
	type:'',
    functionName:'',
    list:''
})

const header = computed(() => Header)
const footer = computed(() => Footer)
// const  users = computed(() => store.getters['user/getAllUsers'])
// const  consumptionStatement = computed(() => store.getters['user/getAllCardRechAndConsump'])
// const  obuStatement = computed(() => store.getters['user/getAllOBURechAndConsump'])

// const resetStatement = () => { statement.list='' }

const getStatement = async () => {
    if(statement.type=='' || statementDate.value==''){        
        alert("Please select a start date and end date and statement type")
    }else{
        statement.list=''
        isFetchingStatement.value = true
        if(statement.type=="MTC"){ statement.functionName="user/cardRechAndConsump" }
        if(statement.type=="ETC"){ statement.functionName="user/obuRechAndConsump" }
        store.dispatch(statement.functionName, reactive({date: statementDate }))
        .then(response => {
            isFetchingStatement.value = false
            statement.list=response.data
        })
        .catch(error => {
            isFetchingStatement.value = false
            errorMessage.value = error.response.data.message !== undefined ? error.response.data.message : ''
            errors.value = error.response.data.errors
        })
    }
}
const exportToCsv = async () => {
    if (statement.type == '' || statementDate.value == '') {
        alert("Please select a start date and end date and statement type")
    } else {
        isExporting.value = true
        if (statement.type == "MTC") {
            statement.functionName = "user/cardRechAndConsump"
        }
        if (statement.type == "ETC") {
            statement.functionName = "user/obuRechAndConsump"
        }
        store.dispatch(statement.functionName, reactive({date: statementDate}))
            .then(response => {
                    isExporting.value = false
                    statement.list = response.data

                    let items = [];

                    let sorted=statement.list.dataList.sort((a, b) => new moment(a.transTime) - new moment(b.transTime))

                    sorted.forEach((item) => {
                        if(statement.type=='ETC'){
                            items.push({
                                cardNo: (item.operationType == 1) ? '--' : item.OBUNO,
                                amount: item.amount,
                                balance_before: item.preBalance,
                                balance_after: item.afterBalance,
                                transaction_type: convertOpType(item.operationType),
                                enStationId: (item.operationType == 1) ? '--' : item.enStationId,
                                exStationId: (item.operationType == 1) ? '--' : item.exStationId,
                                date: item.transTime,
                            });
                        }else {
                            items.push({
                                cardNo: (item.operationType == 1) ? '--' : item.cardNo,
                                amount: item.amount,
                                balance_before: item.preBalance,
                                balance_after: item.afterBalance,
                                transaction_type: convertOpType(item.operationType),
                                exStationId: (item.operationType == 1) ? '--' : item.exStationId,
                                date: item.transTime,
                            });
                        }
                    });

                    if(statement.type=='ETC'){
                        var headers = {
                            cardNo:  (statement.type=='MTC')?'Card No':'OBU Number',
                            amount: 'Amount',
                            balance_before: 'Balance Before',
                            balance_after: 'Balance After',
                            transaction_type: 'Transaction Type',
                            enStationId:'Entry Station',
                            exStationId:'Exit Station',
                            date: 'Date',
                        }
                    }else{
                        var headers = {
                            cardNo:  (statement.type=='MTC')?'Card No':'OBU Number',
                            amount: 'Amount',
                            balance_before: 'Balance Before',
                            balance_after: 'Balance After',
                            transaction_type: 'Transaction Type',
                            exStationId:'Exit Station',
                            date: 'Date',
                        };
                    }

                    items.unshift(headers);

                    // Convert Object to JSON
                    var jsonObject = JSON.stringify(items);

                    var csv = convertToCSV(jsonObject);

                    var exportedFilenmae = statement.type+' Statement '+moment(statement.list.staTransTime).format("MMM DD, YYYY [at] h:mm a") + ' - ' + moment(statement.list.endTransTime).format("MMM DD, YYYY [at] h:mm a")+'.csv';

                    var blob = new Blob([csv], {type: 'text/csv;charset=utf-8;'});
                    if (navigator.msSaveBlob) {
                        navigator.msSaveBlob(blob, exportedFilenmae);
                    } else {
                        var link = document.createElement('a');
                        if (link.download !== undefined) {
                            var url = URL.createObjectURL(blob);
                            link.setAttribute('href', url);
                            link.setAttribute('download', exportedFilenmae);
                            link.style.visibility = 'hidden';
                            document.body.appendChild(link);
                            link.click();
                            document.body.removeChild(link);
                        }
                    }
                }
            ).catch(error => {
            console.log(error)
            isExporting.value = false
            errorMessage.value = error.response.data.message !== undefined ? error.response.data.message : ''
            errors.value = error.response.data.errors
        })
    }
}

function convertOpType(type) {
    if (type == 1) {
        return 'Account Top up'
    }
    if (type == 2) {
        return 'Toll Payment'
    }
}

function convertToCSV(objArray) {
    var array = typeof objArray != 'object' ? JSON.parse(objArray) : objArray;
    var str = '';

    for (var i = 0; i < array.length; i++) {
        var line = '';
        for (var index in array[i]) {
            if (line != '') line += ',';

            line += array[i][index];
        }

        str += line + '\r\n';
    }

    return str;
}
</script>
