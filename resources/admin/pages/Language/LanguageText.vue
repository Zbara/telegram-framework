<template>
    <div class="card">
        <div class="card-header">
            <h3 class="card-title">Переводы</h3>
            <div class="card-body">
                <div class="d-flex">
                    <div class="ms-auto text-muted">
                        <button class="btn btn-primary d-sm-inline-block" @click="this.modal.show()">
                            Добавить перевод
                        </button>
                    </div>
                </div>
            </div>
        </div>
        <div class="table-responsive">
            <table class="table card-table table-vcenter text-nowrap datatable">
                <thead>
                <tr>
                    <th>Key</th>
                    <th v-for="item in languageItems">{{ item.value }}</th>
                    <th></th>
                </tr>
                </thead>
                <tbody>
                    <tr v-for="item in keysItems" :data-id="item">
                        <td>
                            {{ item }}
                        </td>
                        <td v-for="language in languageItems">
                            <textarea rows="5" class="form-control" :data-id="item" :data-lang="language.value" @blur="saveLangText">{{ findValue(item, language.value) }}</textarea>
                        </td>
                        <td class="text-nowrap text-muted">
                            <span class="text-muted cursor-pointer" @click="editLang" :data-id="item">
                                <IconEdit class="icon icon-tabler icon-tabler-trash" width="24" height="24"/>
                            </span>
                        </td>
                    </tr>

                </tbody>
            </table>
        </div>
    </div>
    <div class="modal" ref="langModal" aria-hidden="true" aria-labelledby="LangModalLabel"
         tabindex="-1">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" v-if="!isEdit" id="LangModalLabel">Добавление перевода</h5>
                    <h5 class="modal-title" v-if="isEdit" id="LangModalLabel">Редактирование перевода</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close" @click="isEdit = false, edit.editId = null "></button>
                </div>
                <form class="modal-body" @submit.prevent="createLang" id="addLang">
                    <div class="mb-3">
                        <label class="form-label required">Код перевода</label>
                        <input
                            type="text"
                            class="form-control"
                            name="key"
                            placeholder="Введите код перевода"
                            @focus="hideError"
                            :value="edit.editId"
                            required
                            :disabled="isEdit"
                        />
                        <div class="invalid-feedback"></div>
                    </div>
                    <div v-if="!isEdit" class="mb-3" v-for="item in languageItems">
                        <label class="form-label required">{{  item.value.toUpperCase() }}</label>
                        <textarea
                            type="text"
                            class="form-control"
                            :name="'text[' + item.value +']'"
                            placeholder="Введите перевод"
                            @focus="hideError"
                            rows="5"
                            required
                        />
                        <div class="invalid-feedback"></div>
                    </div>
                    <div v-if="isEdit" class="mb-3" v-for="item in languageItems">
                        <label class="form-label required">{{  item.value.toUpperCase() }}</label>
                        <textarea
                            type="text"
                            class="form-control"
                            :name="'text[' + item.value +']'"
                            placeholder="Введите перевод"
                            @focus="hideError"
                            rows="5"
                            :value="findValue(edit.editId, item.value)"
                            required
                        />
                        <div class="invalid-feedback"></div>
                    </div>
                </form>
                <div class="modal-footer">
                    <button class="btn btn-primary ms-auto" form="addLang" v-if="!isEdit">
                        Добавить
                    </button>
                    <button class="btn btn-primary ms-auto" form="addLang" v-if="isEdit">
                        Изменить
                    </button>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
import {Modal} from "bootstrap";
import {IconEdit} from "@tabler/icons-vue";
import axiosClient from "@/core/axios-client.js";

export default {
    name: "LanguageText",
    components: {
        IconEdit
    },
    data() {
        return {
            languageItems: {},
            keysItems: {},
            textItems: {},
            headerProps: [{
                breadcrumb: true,
                textBreadcrumb: 'Языки',
                nameRoute: {
                    name: 'settingsLang',
                },
            }],
            modal: {},
            isEdit: false,
            error: {
                text: {
                },
            },
            edit: {
                editId: null,
            },
        }
    },
    mounted() {
        this.$emit('changeHeaderData', this.headerProps);
        this.modal = new Modal(this.$refs.langModal);
        this.getText();
    },

    methods: {
        createLang(el){
            const form = new FormData(el.target);
            el.target.reset();

            if(this.isEdit){
                form.set('key', this.edit.editId)
            }
            let typeEdit = (this.isEdit) ? 'editLangText' : 'createdLangText';

            axiosClient.post('/admin/settings/' + typeEdit , form).then((resp) => {
                this.modal.hide();
                this.getText();

                this.edit.editId = null;
                this.isEdit = false;
            }).catch((error) => {
                if (error.response.data && error.response.data.errors) {
                    for (let i in error.response.data.errors) {
                        let text = error.response.data.errors[i][0];

                        if (this.error[i] !== undefined) {
                            this.error[i] = true;
                            this.error.text[i] = text;
                        }
                    }
                }
            });
        },
        getText(){
            axiosClient.get('/admin/settings/getLanguageText').then((resp) => {
                this.languageItems = resp.data.language;
                this.textItems = resp.data.text;
                this.keysItems = resp.data.keys;
            }).catch((error) => {});
        },
        findValue(key, lang, notFound = false){
            const foundTranslation = this.textItems.find(item => item.key == key && item.value == lang);

            if (foundTranslation) {
                return foundTranslation.translation;
            }
            if (notFound) {
                return 'Перевод не найден'
            }
        },
        trim(text, limit) {
            text = text.trim();
            if( text.length <= limit) return text;

            text = text.slice(0, limit);

            return text.trim() + "...";
        },

        editLang(event){
            let itemId = event.currentTarget.dataset.id;

            let item = this.textItems.filter(x => x.key === itemId);

            if(item){
                this.isEdit = true;
                this.edit.editId = itemId;
                this.modal.show();
            }
        },

        hideError(el) {
            if (this.error[el.target.name] !== undefined) {
                this.error[el.target.name] = false;
            }
        },

        saveLangText(el){
            const element = el.target;

            axiosClient.post('/admin/settings/editLangOne', {
                text: element.value,
                lang: element.dataset.lang,
                key: element.dataset.id
            }).then((resp) => {
                element.classList.add("green");

                setTimeout( () => {
                    element.classList.remove("green");
                }, 1500);
            }).catch((error) => {
                if (error.response.data && error.response.data.errors) {

                }
            });
        }
    }
}
</script>
<style>
.green {
    border: 1px solid green;
}
</style>
