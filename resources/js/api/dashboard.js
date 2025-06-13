import axios from "axios"



export const dashboard = {


    getDepartamentoChartData : async function(params){
        return axios.get('/admin/api/dashboard/departamentos');
    },

    getLiquidacionesChartData : async function (consulta) {
        return axios.get('/admin/api/dashboard/liquidaciones', {
            params: {
                periodo: consulta
            }
        });
    },

    getConceptosChartData : async function(consulta) {

        return axios.get('/admin/api/dashboard/conceptos', {
            params : {
                periodo : consulta
            }
        });
    }



}

