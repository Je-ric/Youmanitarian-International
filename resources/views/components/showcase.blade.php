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
                            <x-table.th>Header 1</x-table.th>
                            <x-table.th>Header 2</x-table.th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <x-table.td>Content 1</x-table.td>
                            <x-table.td>Content 2</x-table.td>
                        </tr>
                    </tbody>
                </x-table.table>
            </div>
        </section>

        <!-- Page Header Section -->
                
    </div> --}}
    @endsection