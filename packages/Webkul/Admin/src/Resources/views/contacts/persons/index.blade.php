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

        <v-persons></v-persons>

        {!! view_render_event('admin.persons.index.datagrid.after') !!}
    </div>

    @pushOnce('scripts')        
        <script 
            type="text/x-template"
            id="v-persons-template"
        >
            <div class="box-shadow flex flex-col gap-4 rounded-lg border border-gray-200 bg-white dark:border-gray-800 dark:bg-gray-900 max-xl:flex-wrap">
                <div class="bg-gray-50 p-4">
                    <!-- Tabs Section -->
                    <div class="mb-4 flex space-x-4">
                        <!-- Send Message Tab -->
                        <button @click="activeTab = 'sendMessage'" :class="['tab-button', activeTab === 'sendMessage' ? 'bg-gray-200 text-blue-600' : 'text-gray-600']" class="flex items-center space-x-1 rounded-md px-4 py-2 hover:bg-gray-100">
                            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-message-circle h-4 w-4">
                                <path d="M7.9 20A9 9 0 1 0 4 16.1L2 22Z"></path>
                            </svg>

                          <span>Send message</span>
                        </button>
                
                        <!-- Log Note Tab -->
                        <button @click="activeTab = 'logNote'" :class="['tab-button', activeTab === 'logNote' ? 'bg-gray-200 text-blue-600' : 'text-gray-600']" class="flex items-center space-x-1 rounded-md px-4 py-2 hover:bg-gray-100">
                           <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-clipboard h-4 w-4">
                                <rect width="8" height="4" x="8" y="2" rx="1" ry="1"></rect>
                                <path d="M16 4h2a2 2 0 0 1 2 2v14a2 2 0 0 1-2 2H6a2 2 0 0 1-2-2V6a2 2 0 0 1 2-2h2"></path>
                           </svg>

                          <span>Log note</span>
                        </button>
                
                        <!-- Pinned Message Tab -->
                        <button @click="activeTab = 'pinnedMessage'" :class="['tab-button', activeTab === 'pinnedMessage' ? 'bg-gray-200 text-blue-600' : 'text-gray-600']" class="flex items-center space-x-1 rounded-md px-4 py-2 hover:bg-gray-100">
                            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-pin h-4 w-4">
                                <line x1="12" x2="12" y1="17" y2="22"></line>
                                <path d="M5 17h14v-1.76a2 2 0 0 0-1.11-1.79l-1.78-.9A2 2 0 0 1 15 10.76V6h1a2 2 0 0 0 0-4H8a2 2 0 0 0 0 4h1v4.76a2 2 0 0 1-1.11 1.79l-1.78.9A2 2 0 0 0 5 15.24Z"></path>
                            </svg>

                            <span>Pinned Message</span>
                        </button>
                
                        <!-- Schedule Activity Tab -->
                        <x-admin::dropdown position="bottom-right">
                            <x-slot:toggle>
                                <button  class="flex items-center space-x-1 rounded-md px-4 py-2 hover:bg-gray-100">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-calendar h-4 w-4">
                                        <path d="M8 2v4"></path>
                                        <path d="M16 2v4"></path>
                                        <rect width="18" height="18" x="3" y="4" rx="2"></rect>
                                        <path d="M3 10h18"></path>
                                    </svg>
        
                                    <span>Add Followers</span>
                                </button>
                            </x-slot>
                
                            <!-- Admin Dropdown -->
                            <x-slot:content class="mt-2 border-t-0 !p-2">
                                <h2 class="mb-3 text-sm font-semibold">Add Followers</h2>

                                <div class="space-y-2" v-for="follower in followers">
                                    <div class="flex items-center justify-between gap-3 rounded-md p-2 hover:bg-gray-50">
                                        <div class="flex items-center gap-4 space-x-2">
                                            <img src="https://erp.webkul.com/web/image/res.partner/100212/image_128" alt="Devansh Bawari" class="h-8 w-8 rounded-full">
                                            <span class="text-sm text-gray-700">@{{ follower.name }} </span>
                                        </div>

                                        <div class="flex items-center space-x-2">
                                            <button 
                                                class="text-gray-500 hover:text-gray-700"
                                                @click="removeFollower(follower)"
                                            >
                                                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-x">
                                                <path d="M18 6 6 18"></path>
                                                <path d="m6 6 12 12"></path>
                                                </svg>
                                            </button>
                                        </div>
                                    </div>
                                </div>
                            </x-slot>
                        </x-admin::dropdown>
                    </div>

                    <!-- Send Message Section -->
                    <div v-if="activeTab === 'sendMessage'" class="rounded-lg bg-white p-4">
                        <div class="rounded-lg bg-white sm:w-1/3 md:w-1/2">
                            <div class="p-4">
                                <div class="mb-2 text-sm text-gray-500">To: Followers of "Project Name"</div>

                                <div class="">
                                    <div class="rounded-lg border">
                                        <x-admin::form.control-group class="!mb-0">
                                            <x-admin::form.control-group.control
                                                type="textarea"
                                                name="reply"
                                                id="reply"
                                                rules="required"
                                                :tinymce="true"
                                                v-model="message"
                                            />
    
                                            <x-admin::form.control-group.error control-name="reply" />
                                        </x-admin::form.control-group>

                                        <div class="flex items-center justify-between border-t bg-gray-50 px-2 py-2">
                                            <div class="flex space-x-2">
                                                <!-- Message -->
                                                <button class="rounded-md p-2 hover:bg-gray-200">
                                                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-image h-5 w-5 text-gray-500">
                                                        <rect width="18" height="18" x="3" y="3" rx="2" ry="2"></rect>

                                                        <circle cx="9" cy="9" r="2"></circle>

                                                        <path d="m21 15-3.086-3.086a2 2 0 0 0-2.828 0L6 21"></path>
                                                    </svg>
                                                </button>

                                                <!-- Attachement -->
                                                <button class="rounded-md p-2 hover:bg-gray-200">
                                                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-paperclip h-5 w-5 text-gray-500">
                                                        <path d="m21.44 11.05-9.19 9.19a6 6 0 0 1-8.49-8.49l8.57-8.57A4 4 0 1 1 18 8.84l-8.59 8.57a2 2 0 0 1-2.83-2.83l8.49-8.48"></path>
                                                    </svg>
                                                </button>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <div class="flex items-center justify-between">
                                    <div class="flex space-x-2">
                                        <button class="text-green-600 hover:text-green-700">Following</button>

                                        <span class="text-gray-400">•</span>

                                        <span class="text-gray-600">3</span>
                                    </div>

                                    <button 
                                        @click="sendMessage"
                                        class="rounded-md bg-blue-500 px-4 py-2 text-white hover:bg-blue-600"
                                    >
                                        Send
                                    </button>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div v-if="activeTab === 'logNote'" class="tab-content rounded-lg bg-white p-4">
                        <p>Log Note Content</p>
                    </div>

                    <div v-if="activeTab === 'pinnedMessage'" class="tab-content rounded-lg bg-white p-4">
                        <p>Pinned Message Content</p>
                    </div>

                    <div v-if="activeTab === 'scheduleActivity'" class="tab-content rounded-lg bg-white p-4">
                        <p>Schedule Activity Content</p>
                    </div>
                </div>
            </div>

            <div class="box-shadow flex flex-col gap-4 rounded-lg border border-gray-200 bg-white p-3 dark:border-gray-800 dark:bg-gray-900 max-xl:flex-wrap">
                <div class="min-h-full w-full" v-for="message in messages">
                    <div class="mx-auto max-w-5xl bg-white">
                        <div class="border-b border-gray-200 py-4">
                            <div class="mb-4 flex gap-3">
                                <div class="flex-shrink-0">
                                    <div class="flex h-8 w-8 items-center justify-center rounded-full bg-gray-200">
                                        <svg
                                            xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none"
                                            stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"
                                            class="lucide lucide-circle h-4 w-4 text-gray-400">
                                            <circle cx="12" cy="12" r="10"></circle>
                                        </svg>
                                    </div>
                                </div>

                                <div class="flex-grow">
                                    <div class="mb-2 flex items-center gap-2">
                                        <span class="font-medium text-gray-900">@{{ message.user.name }}</span>
                                        <span class="text-sm text-gray-500">@{{ message.ago }}</span>
                                    </div>

                                    <div class="mb-4" v-html="message.content"></div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </script>

        <script type="module">
         app.component('v-persons', {
            template: '#v-persons-template',

            data() {
                return {
                    users: [],
                    followers: [],
                    messages: [],
                    activeTab: '',
                    message: '',
                };
            },

            mounted() {
                this.getMessages();
                this.getFollowers();
            },

            methods: {
                getFollowers() {
                    this.$axios.get('{{ route('tasks.getFollowers', 1) }}')
                        .then(response => {
                            this.followers = response.data;
                        })
                        .catch(error => {
                            console.log(error);
                        });
                },

                getMessages() {
                    this.$axios.get('{{ route('tasks.showMessages', 1) }}')
                        .then(response => {
                            this.messages = response.data;
                        })
                        .catch(error => {
                            console.log(error);
                        });
                },

                sendMessage() {
                    if (this.message == '') {
                        return;
                    }

                    this.$axios.post('{{ route('tasks.postMessage', 1) }}', {
                        content: this.message
                    })
                        .then(response => {
                            console.log(response);
                        })
                        .catch(error => {
                            console.log(error);
                        });
                },
            },
        });

        </script>
    @endPushOnce
</x-admin::layouts>
