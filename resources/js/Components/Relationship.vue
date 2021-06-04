<template>
    <div v-if="relationship.records.data.length > 0">
        <div class="space-y-3" v-if="relationship.type == 'multiple'">
            <Table>
                <template v-slot:thead>
                    <th scope="col" v-for="field in relationship.fields" :key="`field-${field.column}`" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                        <span> {{ field.name }} </span>
                    </th>
                </template>

                <template v-slot:tbody>
                    <tr v-for="record in relationship.records.data" :key="record.id" class="hover:bg-gray-50 transition duration-75">
                        <td v-for="field in relationship.fields" :key="`record-${record.id}-${field.column}`" class="whitespace-nowrap px-6 py-4">
                            <span class="text-sm font-medium text-gray-900"> {{ record[field.column] }} </span>
                        </td>
                    </tr>
                </template>
            </Table>

            <Pagination :links="relationship.records.links" />
        </div>

        <RecordForm :record="relationship.records.data[0]" :fields="relationship.fields" v-else-if="relationship.type == 'single'" />
    </div>

    <div class="shadow bg-white rounded-md p-8" v-else>
        <p class="font-medium"> No records found </p>
    </div>
</template>

<script>
import Table from './Table';
import RecordForm from './RecordForm';
import ResourceRecords from './ResourceRecords';
import Pagination from './Pagination';

export default {
    props: [
        'relationship'
    ],
    components: {
        Table,
        RecordForm,
        ResourceRecords,
        Pagination
    }
}
</script>
