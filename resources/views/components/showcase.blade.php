@extends('layouts.sidebar_final')


@section('content')
<x-page-header icon="bx-user" title="Employee" desc="Manage your employee">
    <div class="flex items-center gap-2">
        <x-button variant="secondary">
            <i class='bx bx-export mr-1'></i>
            Export
        </x-button>
        <x-button variant="primary">
            <i class='bx bx-plus mr-1'></i>
            Add Employee
        </x-button>
    </div>
</x-page-header>
<x-navigation-layout.tabs-modern
:tabs="[
    ['id' => 'modern1', 'label' => 'Overview', 'icon' => 'bx-home'],
    ['id' => 'modern2', 'label' => 'Requests', 'icon' => 'bx-calendar'],
    ['id' => 'modern3', 'label' => 'Settings', 'icon' => 'bx-cog']
]"
defaultTab="modern1"
>
<div class="container mx-auto px-4 py-8">
    @slot('slot_modern1')
        <div>
            <h4 class="text-lg font-semibold mb-2">Overview</h4>
            <p>This is the overview tab content. You can place any Blade or HTML here.</p>
        </div>
    @endslot
    @slot('slot_modern2')
        <div>
            <h4 class="text-lg font-semibold mb-2">Requests</h4>
            <p>This is the requests tab content. You can place any Blade or HTML here.</p>
        </div>
    @endslot
    @slot('slot_modern3')
        <div>
            <h4 class="text-lg font-semibold mb-2">Settings</h4>
            <p>This is the settings tab content. You can place any Blade or HTML here.</p>
        </div>
    @endslot
</div>
</x-navigation-layout.tabs-modern>

    {{-- <div class="container mx-auto px-4 py-8">
        <h1 class="text-3xl font-bold mb-8">Component Showcase</h1>

        <!-- Buttons Section -->
        <section class="mb-12">
            <h2 class="text-2xl font-semibold mb-4">Buttons</h2>
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4 p-4 bg-white rounded-lg shadow">
                <div>
                    <h3 class="text-lg font-medium mb-3">Primary Variants</h3>
                    <div class="space-y-2">
                        <x-button variant="primary">Primary Button</x-button>
                        <x-button variant="secondary">Secondary Button</x-button>
                        <x-button variant="success">Success Button</x-button>
                        <x-button variant="danger">Danger Button</x-button>
                        <x-button variant="warning">Warning Button</x-button>
                        <x-button variant="info">Info Button</x-button>
                    </div>
                </div>
                <div>
                    <h3 class="text-lg font-medium mb-3">Action Variants</h3>
                    <div class="space-y-2">
                        <x-button variant="manage">Manage Button</x-button>
                        <x-button variant="restore">Restore Button</x-button>
                        <x-button variant="approve">Approve Button</x-button>
                        <x-button variant="delete">Delete Button</x-button>
                        <x-button variant="cancel">Cancel Button</x-button>
                        <x-button variant="test">Test Button</x-button>
                    </div>
                </div>
            </div>
        </section>

        <!-- Links Section -->
        <section class="mb-12">
            <h2 class="text-2xl font-semibold mb-4">Links</h2>
            <div class="grid grid-cols-1 md:grid-cols-2 gap-4 p-4 bg-white rounded-lg shadow">
                <div>
                    <h3 class="text-lg font-medium mb-3">Link Variants</h3>
                    <div class="space-y-2">
                        <x-link href="#" variant="primary">Primary Link</x-link>
                        <x-link href="#" variant="secondary">Secondary Link</x-link>
                        <x-link href="#" variant="danger">Danger Link</x-link>
                        <x-link href="#" variant="success">Success Link</x-link>
                        <x-link href="#" variant="outline">Outline Link</x-link>
                    </div>
                </div>
                <div>
                    <h3 class="text-lg font-medium mb-3">Link Sizes</h3>
                    <div class="space-y-2">
                        <x-link href="#" size="sm">Small Link</x-link>
                        <x-link href="#" size="md">Medium Link</x-link>
                        <x-link href="#" size="lg">Large Link</x-link>
                    </div>
                </div>
            </div>
        </section>

        <!-- Status Indicators Section -->
        <section class="mb-12">
            <h2 class="text-2xl font-semibold mb-4">Status Indicators</h2>
            <div class="grid grid-cols-1 md:grid-cols-2 gap-4 p-4 bg-white rounded-lg shadow">
                <div>
                    <h3 class="text-lg font-medium mb-3">Basic Statuses</h3>
                    <div class="space-y-2">
                        <x-feedback-status.status-indicator status="success" />
                        <x-feedback-status.status-indicator status="neutral" />
                        <x-feedback-status.status-indicator status="info" />
                        <x-feedback-status.status-indicator status="warning" />
                        <x-feedback-status.status-indicator status="danger" />
                    </div>
                </div>
                <div>
                    <h3 class="text-lg font-medium mb-3">Progress Statuses</h3>
                    <div class="space-y-2">
                        <x-feedback-status.status-indicator status="completed" />
                        <x-feedback-status.status-indicator status="in_progress" />
                        <x-feedback-status.status-indicator status="pending" />
                        <x-feedback-status.status-indicator status="rejected" />
                        <x-feedback-status.status-indicator status="approved" />
                        <x-feedback-status.status-indicator status="role" />
                    </div>
                </div>
            </div>
        </section>

        <!-- Alerts Section -->
        <section class="mb-12">
            <h2 class="text-2xl font-semibold mb-4">Alerts</h2>
            <div class="space-y-4 p-4 bg-white rounded-lg shadow">
                <x-feedback-status.alert type="success" message="This is a success message" />
                <x-feedback-status.alert type="error" message="This is an error message" />
                <x-feedback-status.alert type="info" message="This is an info message" />
                <x-feedback-status.alert type="warning" message="This is a warning message" />
                <x-feedback-status.alert type="neutral" message="This is a neutral message" />
                
                <h3 class="text-lg font-medium mt-6 mb-3">Attendance Variant</h3>
                <x-feedback-status.alert 
                    variant="attendance" 
                    type="success" 
                    message="This is an attendance success message" 
                />
            </div>
        </section>

        <!-- Empty States Section -->
        <section class="mb-12">
            <h2 class="text-2xl font-semibold mb-4">Empty States</h2>
            <div class="space-y-8 p-4 bg-white rounded-lg shadow">
                <!-- Default Empty States -->
                <div>
                    <h3 class="text-lg font-medium mb-3">Basic Empty States</h3>
                    <x-empty-state variant="default" />
                    <x-empty-state variant="loading" />
                    <x-empty-state variant="error" />
                </div>

                <!-- Content Empty States -->
                <div>
                    <h3 class="text-lg font-medium mb-3">Content Empty States</h3>
                    <x-empty-state variant="no-data" />
                    <x-empty-state variant="empty-table" />
                </div>

                <!-- Role Empty States -->
                <div>
                    <h3 class="text-lg font-medium mb-3">Role Empty States</h3>
                    <x-empty-state variant="no-roles" />
                    <x-empty-state variant="no-permissions" />
                </div>

                <!-- Analytics Empty States -->
                <div>
                    <h3 class="text-lg font-medium mb-3">Analytics Empty States</h3>
                    <x-empty-state variant="no-reports" />
                    <x-empty-state variant="no-analytics" />
                </div>

                <!-- Success Empty States -->
                <div>
                    <h3 class="text-lg font-medium mb-3">Success Empty States</h3>
                    <x-empty-state variant="completed" />
                    <x-empty-state variant="success" />
                </div>

                <!-- Empty State Sizes -->
                <div>
                    <h3 class="text-lg font-medium mb-3">Empty State Sizes</h3>
                    <x-empty-state variant="default" size="small" />
                    <x-empty-state variant="default" size="default" />
                    <x-empty-state variant="default" size="large" />
                </div>
            </div>
        </section>

        <!-- Form Elements Section -->
        <section class="mb-12">
            <h2 class="text-2xl font-semibold mb-4">Form Elements</h2>
            <div class="grid grid-cols-1 md:grid-cols-2 gap-4 p-4 bg-white rounded-lg shadow">
                <!-- Labels -->
                <div>
                    <h3 class="text-lg font-medium mb-3">Labels</h3>
                    <x-form.label for="example">
                        <i class='bx bx-user'></i>
                        Example Label
                    </x-form.label>
                </div>

                <!-- File Upload -->
                <div>
                    <h3 class="text-lg font-medium mb-3">File Upload</h3>
                    <x-form.input-upload name="example" id="example" />
                </div>
            </div>
        </section>

        <!-- Modal Components Section -->
        <section class="mb-12">
            <h2 class="text-2xl font-semibold mb-4">Modal Components</h2>
            <div class="grid grid-cols-1 md:grid-cols-2 gap-4 p-4 bg-white rounded-lg shadow">
                <!-- Close Buttons -->
                <div>
                    <h3 class="text-lg font-medium mb-3">Modal Close Buttons</h3>
                    <div class="space-y-2">
                        <x-modal.close-button modalId="example" text="Close Modal" />
                        <x-modal.close-button modalId="example" text="Cancel" variant="cancel" />
                    </div>
                </div>
            </div>
        </section>

        <!-- Tab Components Section -->
        <section class="mb-12">
            <h2 class="text-2xl font-semibold mb-4">Tab Components</h2>
            <div class="p-4 bg-white rounded-lg shadow">
                <x-navigation-layout.tabs
                    :tabs="[
                        ['id' => 'tab1', 'label' => 'Tab One', 'icon' => 'bx-home'],
                        ['id' => 'tab2', 'label' => 'Tab Two', 'icon' => 'bx-user'],
                        ['id' => 'tab3', 'label' => 'Tab Three', 'icon' => 'bx-cog']
                    ]"
                    defaultTab="tab1"
                >
                    @slot('slot_tab1')
                        <div>
                            <h4 class="text-lg font-semibold mb-2">Tab One Content</h4>
                            <p>This is the content for Tab One. You can put any Blade or HTML here.</p>
                        </div>
                    @endslot
                    @slot('slot_tab2')
                        <div>
                            <h4 class="text-lg font-semibold mb-2">Tab Two Content</h4>
                            <p>This is the content for Tab Two. You can put any Blade or HTML here.</p>
                        </div>
                    @endslot
                    @slot('slot_tab3')
                        <div>
                            <h4 class="text-lg font-semibold mb-2">Tab Three Content</h4>
                            <p>This is the content for Tab Three. You can put any Blade or HTML here.</p>
                        </div>
                    @endslot
                </x-navigation-layout.tabs>
            </div>
        </section>
        <!-- Table Components Section -->
        <section class="mb-12">
            <h2 class="text-2xl font-semibold mb-4">Table Components</h2>
            <div class="p-4 bg-white rounded-lg shadow">
                <x-table.table>
                    <thead>
                        <tr>
                            <x-table.th class="w-10 text-center">#</x-table.th>
                            <x-table.th>Header 1</x-table.th>
                            <x-table.th>Header 2</x-table.th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <x-table.td class="w-10 text-center text-gray-500">{{ $loop->iteration }}</x-table.td>
                            <x-table.td>Content 1</x-table.td>
                            <x-table.td>Content 2</x-table.td>
                        </tr>
                    </tbody>
                </x-table.table>
            </div>
        </section>

        <!-- Page Header Section -->
                
    </div> --}}

    <!-- Form Components Section -->
    <section class="mb-12">
        <h2 class="text-2xl font-semibold mb-4">Form Components</h2>
        <div class="grid grid-cols-1 md:grid-cols-2 gap-4 p-4 bg-white rounded-lg shadow">
            <!-- Label -->
            <div>
                <h3 class="text-lg font-medium mb-3">Label</h3>
                <x-form.label for="showcase_label">
                    <i class='bx bx-user'></i>
                    Showcase Label
                </x-form.label>
            </div>
            <!-- Input Upload -->
            <div>
                <h3 class="text-lg font-medium mb-3">Input Upload</h3>
                <x-form.input-upload name="showcase_upload" id="showcase_upload" />
            </div>
            <!-- Textarea -->
            <div>
                <h3 class="text-lg font-medium mb-3">Textarea</h3>
                <x-form.textarea name="showcase_textarea" id="showcase_textarea" label="Showcase Textarea" placeholder="Type here..." />
            </div>
            <!-- Select Option -->
            <div>
                <h3 class="text-lg font-medium mb-3">Select Option</h3>
                <x-form.select-option name="showcase_select" label="Showcase Select" :options="[['value' => '1', 'label' => 'Option 1'], ['value' => '2', 'label' => 'Option 2']]" />
            </div>
            <!-- Checkbox -->
            <div>
                <h3 class="text-lg font-medium mb-3">Checkbox</h3>
                <x-form.checkbox name="showcase_checkbox" id="showcase_checkbox" />
                <label for="showcase_checkbox" class="ml-2 text-sm">Showcase Checkbox</label>
            </div>
            <!-- Radio Group -->
            <div>
                <h3 class="text-lg font-medium mb-3">Radio Group</h3>
                <x-form.radio-group name="showcase_radio" label="Showcase Radio" :options="['one' => 'One', 'two' => 'Two']" selected="one" />
            </div>
            <!-- Toggle -->
            <div>
                <h3 class="text-lg font-medium mb-3">Toggle</h3>
                <x-form.toggle name="showcase_toggle" label="Showcase Toggle" />
            </div>
            <!-- Date Picker -->
            <div>
                <h3 class="text-lg font-medium mb-3">Date Picker</h3>
                <x-form.date-picker name="showcase_date" id="showcase_date" />
            </div>
            <!-- Time Picker -->
            <div>
                <h3 class="text-lg font-medium mb-3">Time Picker</h3>
                <x-form.time-picker name="showcase_time" id="showcase_time" />
            </div>
            <!-- Button Group -->
            <div>
                <h3 class="text-lg font-medium mb-3">Button Group</h3>
                <x-form.button-group>
                    <x-button variant="primary">Button 1</x-button>
                    <x-button variant="secondary">Button 2</x-button>
                </x-form.button-group>
            </div>
            <!-- General Input: Name -->
            <div>
                <h3 class="text-lg font-medium mb-3">Input (Name)</h3>
                <x-form.input name="showcase_name" type="name" label="Full Name" placeholder="Enter your name" required />
            </div>
            <!-- General Input: Email -->
            <div>
                <h3 class="text-lg font-medium mb-3">Input (Email)</h3>
                <x-form.input name="showcase_email" type="email" label="Email Address" placeholder="Enter your email" required />
            </div>
            <!-- General Input: Number -->
            <div>
                <h3 class="text-lg font-medium mb-3">Input (Number)</h3>
                <x-form.input name="showcase_number" type="number" label="Age" placeholder="Enter your age" required />
            </div>
        </div>
    </section>


    <div class="container mx-auto px-4 sm:px-6 lg:px-8 py-8">
    
        <!-- Page Header -->
        <div class="mb-8">
            <h1 class="text-3xl font-bold text-[#1a2235] mb-2">Card Component Showcase</h1>
            <p class="text-gray-600">Professional card designs for organizational use</p>
        </div>
    
        <!-- Card Variants Grid -->
        <div class="grid grid-cols-1 lg:grid-cols-2 xl:grid-cols-3 gap-6 mb-12">
            
            <!-- Default Variant -->
            <x-card title="Default Professional" icon="bx-info-circle" variant="default">
                <div class="space-y-3">
                    <p class="text-gray-700 text-sm leading-relaxed">
                        Clean, professional design with subtle gradients and proper contrast ratios.
                    </p>
                    <div class="flex items-center gap-2 text-xs text-gray-500">
                        <i class='bx bx-check-circle text-green-500'></i>
                        <span>Perfect for general content</span>
                    </div>
                </div>
            </x-card>
    
            <!-- Gradient Variant -->
            <x-card title="Gradient Accent" icon="bx-palette" variant="gradient">
                <div class="space-y-3">
                    <p class="text-gray-700 text-sm leading-relaxed">
                        Eye-catching gradient design that draws attention while maintaining professionalism.
                    </p>
                    <div class="flex items-center gap-2 text-xs text-gray-500">
                        <i class='bx bx-star text-[#ffb51b]'></i>
                        <span>Great for featured content</span>
                    </div>
                </div>
            </x-card>
    
            <!-- Minimal Variant -->
            <x-card title="Minimal Clean" icon="bx-minimize" variant="minimal">
                <div class="space-y-3">
                    <p class="text-gray-700 text-sm leading-relaxed">
                        Clean, minimal design with accent border for subtle emphasis.
                    </p>
                    <div class="flex items-center gap-2 text-xs text-gray-500">
                        <i class='bx bx-layout text-blue-500'></i>
                        <span>Ideal for data displays</span>
                    </div>
                </div>
            </x-card>
    
            <!-- Elevated Variant -->
            <x-card title="Elevated Premium" icon="bx-crown" variant="elevated" size="default">
                <div class="space-y-3">
                    <p class="text-gray-700 text-sm leading-relaxed">
                        Premium design with enhanced shadows and decorative elements for important content.
                    </p>
                    <div class="flex items-center gap-2 text-xs text-gray-500">
                        <i class='bx bx-award text-purple-500'></i>
                        <span>Perfect for highlights</span>
                    </div>
                </div>
            </x-card>
    
            <!-- Bordered Variant -->
            <x-card title="Bordered Formal" icon="bx-border-all" variant="bordered">
                <div class="space-y-3">
                    <p class="text-gray-700 text-sm leading-relaxed">
                        Formal design with defined borders, perfect for official documentation.
                    </p>
                    <div class="flex items-center gap-2 text-xs text-gray-500">
                        <i class='bx bx-file text-indigo-500'></i>
                        <span>Great for forms & docs</span>
                    </div>
                </div>
            </x-card>
    
            <!-- Custom Example -->
            <x-card 
                title="Custom Colors" 
                icon="bx-customize" 
                variant="default"
                headerColor="bg-gradient-to-r from-emerald-600 to-teal-600 text-white"
                bodyColor="bg-emerald-50"
            >
                <div class="space-y-3">
                    <p class="text-gray-700 text-sm leading-relaxed">
                        Fully customizable with your own color schemes and branding.
                    </p>
                    <div class="flex items-center gap-2 text-xs text-gray-500">
                        <i class='bx bx-color text-emerald-500'></i>
                        <span>Unlimited customization</span>
                    </div>
                </div>
            </x-card>
        </div>
    </div>

    
    @endsection