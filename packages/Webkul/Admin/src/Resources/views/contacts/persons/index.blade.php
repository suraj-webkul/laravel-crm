<x-admin::layouts>
    <x-slot:title>
        @lang('admin::app.contacts.persons.index.title')
    </x-slot>

    <div class="flex flex-col gap-4">
        <div class="flex items-center justify-between rounded-lg border border-gray-200 bg-white px-4 py-2 text-sm dark:border-gray-800 dark:bg-gray-900 dark:text-gray-300">
            <div class="flex flex-col gap-2">
                <div class="flex cursor-pointer items-center">
                    <x-admin::breadcrumbs name="contacts.persons" />
                </div>

                <div class="text-xl font-bold dark:text-white">
                    @lang('admin::app.contacts.persons.index.title')
                </div>
            </div>

            <div class="flex items-center gap-x-2.5">
                <!-- Create button for person -->
                <div class="flex items-center gap-x-2.5">
                    {!! view_render_event('admin.persons.index.create_button.before') !!}

                    @if (bouncer()->hasPermission('admin.contacts.persons.view'))
                        <a
                            href="{{ route('admin.contacts.persons.create') }}"
                            class="primary-button"
                        >
                            @lang('admin::app.contacts.persons.index.create-btn')
                        </a>
                    @endif

                    {!! view_render_event('admin.persons.index.create_button.after') !!}
                </div>
            </div>
        </div>

        {!! view_render_event('admin.persons.index.datagrid.before') !!}

        <v-messages></v-messages>

        {!! view_render_event('admin.persons.index.datagrid.after') !!}
    </div>

    @pushOnce('scripts')        
        <script 
            type="text/x-template"
            id="v-messages-template"
        >
            <div class="mx-auto my-4 flex max-w-3xl flex-col gap-4">
                <div class="flex items-center gap-4">
                    <textarea
                        v-model="message"
                        name="title"
                        class="flex-grow rounded border border-gray-300 px-3 py-2 text-sm font-medium text-gray-800 transition-all hover:border-gray-400 focus:border-gray-500 dark:border-gray-700 dark:bg-gray-800 dark:text-gray-200 dark:hover:border-gray-600 dark:focus:border-gray-500"
                        placeholder="Email Title"
                    ></textarea>
                   
                    <button
                        @click="store"
                        class="rounded-md bg-purple-600 px-4 py-2 font-medium text-white hover:bg-purple-700 focus:outline-none focus:ring-2 focus:ring-purple-500 focus:ring-offset-2"
                    >
                        Send
                    </button>
                    
                    <button
                        class="rounded-md bg-green-600 px-4 py-2 font-medium text-white hover:bg-green-700 focus:outline-none focus:ring-2 focus:ring-green-500 focus:ring-offset-2"
                    >
                        Add Follower
                    </button>
                </div>
            
                <div class="flex gap-2" v-for="msg in messages">
                    <div class="icon-mail mt-2 flex h-9 min-h-9 w-9 min-w-9 items-center justify-center rounded-full bg-green-200 text-xl text-green-900 dark:!text-green-900">
                        <!-- Icon placeholder, e.g., <i class="fas fa-envelope"></i> -->
                    </div>
                    
                    <div class="flex w-full justify-between gap-4 rounded-md bg-white p-4 shadow-md dark:bg-gray-900 dark:shadow-none">
                        <div class="flex flex-col gap-2">
                            <div class="flex flex-col gap-1">
                                <p class="flex items-center gap-1 font-medium dark:text-white">TEST MAIL FOR THE DRAFT</p>
                                <p class="text-gray-500 dark:text-gray-300">From: laravel@krayincrm.com</p>
                                <p class="text-gray-500 dark:text-gray-300">To: c@example.com</p> <!-- Added recipient email -->
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </script>

        <script type="module">
            app.component('v-messages', {
                template: '#v-messages-template',

                data() {
                    return {
                        messages: [],
                        message: '',
                    }
                },

                mounted() {
                    this.get();
                },

                methods: {
                    get() {
                        this.$axios.get('{{ route('contact.person.messages') }}')
                            .then(response => {
                                this.messages = response.data;
                            })
                            .catch(error => {
                                console.log(error);
                            })
                    },

                    store() {
                        if (this.message == '') {
                            return;
                        }

                        this.$axios.post('{{ route('contact.person.messages.store') }}', {
                            message: this.message
                        })
                            .then(response => {
                                this.get();
                            })
                            .catch(error => {
                                console.log(error);
                            })
                    }
                }
            });
        </script>
    @endPushOnce
</x-admin::layouts>
