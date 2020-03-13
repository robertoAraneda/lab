<template>
    <div class="col-md-12">
        <div class="card">
            <div class="card-body p-0">
                <div class="table-responsive mailbox-messages">
                    <table class="table table-hover">
                        <tbody>
                            <tr v-for="analyte in activeAnalytes" :key="analyte.id">
                                <td class="mailbox-star" style="min-width: 100px;">
                                    <span class="text-secondary">
                                        {{ analyte.loinc.loinc_num }}</span
                                    >
                                </td>
                                <td class="mailbox-name">
                                    <a :href="'/search/advanced/'+ analyte.id"> {{ analyte.description }}</a>
                                </td>
                                <td class="mailbox-subject" style="max-width: 180px;">
                                    <b>Area de trabajo: </b>
                                    {{ analyte.work_area.description }}
                                </td>
                                <td class="mailbox-date">
                                    {{ analyte.available.description }}
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
export default {
    props: ["analytes", "propsSearch"],
    data() {
        return {};
    },
    created() {},
    computed:{
      activeAnalytes(){
          return this.analytes.filter(analyte =>{
              return analyte.is_checked === 1
          })
      }  
    },
    methods: {}
};
</script>

<style scoped></style>
