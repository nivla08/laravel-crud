@section('page-title') ENVeditor @endsection
@section('breadcrumbs')
<div class="row wrapper border-bottom white-bg page-heading">
	<div class="col-sm-4">
		<h2>Env-Editor</h2>
		{{ Breadcrumbs::render('settings-configuration') }}
	</div>
</div>
@endsection
@extends('layouts.master')
@section('wrapper-content')
    @yield('content')
@endsection
@section('js-plugin')
<script src="https://cdnjs.cloudflare.com/ajax/libs/vue/1.0.26/vue.js"></script>
@endsection
@section('js-custom')
<script>
    new Vue({
        el: '#app',
        data: {
            loadButton: true,
            alertsuccess: 0,
            alertmessage: '',
            views: [
                {name: "{{ trans('dotenv-editor::views.overview') }}", active: 1},
                {name: "{{ trans('dotenv-editor::views.addnew') }}", active: 0},
                {name: "{{ trans('dotenv-editor::views.backups') }}", active: 0},
                {name: "{{ trans('dotenv-editor::views.upload') }}", active: 0}
            ],
            newEntry: {
                key: "",
                value: ""
            },
            details: {},
            currentBackup: {
                timestamp: ''
            },
            toEdit: {},
            toDelete: {},
            deleteModal: {
                title: '',
                content: ''
            },
            token: "{!! csrf_token() !!}",
            entries: [

            ]
        },
        methods: {
            loadEnv: function(){
                var vm = this;
                this.loadButton = false;
                $.getJSON("/{{ $url }}/getdetails", function(items){
                    vm.entries = items;
                });
            },
            setActiveView: function(viewName){
                $.each(this.views, function(key, value){
                    if(value.name == viewName){
                        value.active = 1;
                    } else {
                        value.active = 0;
                    }
                })
            },
            addNew: function(){
                var vm = this;
                var newkey = this.newEntry.key;
                var newvalue = this.newEntry.value;
                $.ajax({
                    url: "/{{ $url }}/add",
                    type: "post",
                    data: {
                        _token: this.token,
                        key: newkey,
                        value: newvalue
                    },
                    success: function(){
                        vm.entries.push({
                            key: newkey,
                            value: newvalue
                        });
                        var msg = "{{ trans('dotenv-editor::views.new_entry_added') }}";
                        toastr.success(msg);
                        vm.alertsuccess = 1;
                        $("#newkey").val("");
                        vm.newEntry.key = "";
                        vm.newEntry.value = "";
                        $("#newvalue").val("");
                        $('#newkey').focus();
                    }
                })
            },
            editEntry: function(entry){
                this.toEdit = {};
                this.toEdit = entry;
                $('#editModal').modal('show');
            },
            updateEntry: function(){
                var vm = this;
                $.ajax({
                    url: "/{{ $url }}/update",
                    type: "post",
                    data: {
                        _token: this.token,
                        key: vm.toEdit.key,
                        value: vm.toEdit.value
                    },
                    success: function(){
                        var msg = "{{ trans('dotenv-editor::views.entry_edited') }}";
                        toastr.success(msg);
                        $('#editModal').modal('hide');
                    }
                })
            },
            makeBackup: function(){
                var vm = this;
                $.ajax({
                    url: "/{{ $url }}/createbackup",
                    type: "get",
                    success: function(){
                        toastr.success("{{ trans('dotenv-editor::views.backup_created') }}");
                    }
                })
            },
            showBackupDetails: function(timestamp, formattedtimestamp){
                this.currentBackup.timestamp = timestamp;
                var vm = this;
                $.getJSON("/{{ $url }}/getdetails/" + timestamp, function(items){
                    vm.details = items;
                    $('#showDetails').modal('show');
                });
            },
            restoreBackup: function(timestamp){
                var vm = this;
                $.ajax({
                    url: "/{{ $url }}/restore/" + timestamp,
                    type: "get",
                    success: function(){
                        vm.loadEnv();
                        $('#showDetails').modal('hide');
                        vm.setActiveView('overview');
                        toastr.success("{{ trans('dotenv-editor::views.backup_restored') }}");
                    }
                })
            },
            deleteEntry: function(){
                var entry = this.toDelete;
                var vm = this;

                $.ajax({
                    url: "/{{ $url }}/delete",
                    type: "post",
                    data: {
                        _token: this.token,
                        key: entry.key
                    },
                    success: function(){
                        var msg = "{{ trans('dotenv-editor::views.entry_deleted') }}";
                        toastr.success(msg);
                    }
                });
                this.entries.$remove(entry);
                this.toDelete = {};
                $('#deleteModal').modal('hide');
            },
            showAlert: function(type, message){
                this.alertmessage = message;
                this.alertsuccess = 1;
            },
            closeAlert: function(){
                this.alertsuccess = 0;
            },
            modal: function(entry){
                this.toDelete = entry;
                this.deleteModal.title = "{{ trans('dotenv-editor::views.delete_entry') }}";
                this.deleteModal.content = entry.key + "=" + entry.value;
                $('#deleteModal').modal('show');
            }
        }
    })
</script>
<script>
    $(document).ready(function(){
        $(function () {
            $('[data-toggle="popover"]').popover()
        });
        $(function () {
            $('[data-toggle="tooltip"]').tooltip()
        });
        @if(session('dotenv'))
        toastr.success('{{session('dotenv')}}');
        @endif
    });
</script>
@endsection
