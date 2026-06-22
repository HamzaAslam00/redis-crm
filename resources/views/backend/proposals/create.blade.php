<x-layouts.backend title="New Proposal">

    <x-backend.page-header title="New Proposal" subtitle="Fill in the details to generate a professional proposal PDF">
        <a href="{{ route('admin.proposals.index') }}" class="btn btn-secondary">
            <i class="ri-arrow-left-line"></i> Back
        </a>
    </x-backend.page-header>

    <x-backend.breadcrumb :items="['Proposals' => route('admin.proposals.index'), 'New Proposal' => null]" />

    @include('backend.proposals._form', [
        'action'       => route('admin.proposals.store'),
        'method'       => 'POST',
        'proposal'     => null,
        'defaultTerms' => $defaultTerms,
    ])

</x-layouts.backend>
