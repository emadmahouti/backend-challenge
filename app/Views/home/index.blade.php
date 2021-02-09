@extends('layouts.master')

@section('content')

    <div class="container">
        <div class="row">
            <div class="col-lg-3">
                <div class="card">
                    <div class="card-body">
                        <div class="form-group">
                            <input type="text" class="form-control" placeholder="Search in Github" title="Github"
                                   v-model="inputs.username">
                        </div>
                        <button type="submit" class="btn btn-primary" v-on:click="submit()">Submit</button>
                    </div>
                </div>
            </div>
            <div class="col-lg-9">
                <div class="card">
                    <div class="card-body">
                        <div class="form-group">
                            <input type="text" class="form-control">
                        </div>
                    </div>
                </div>
                <table class="table table-hover mt-2">
                    <thead class="thead-light">
                    <tr>
                        <th>ID</th>
                        <th>Name</th>
                        <th>Language</th>
                        <th>Description</th>
                        <th></th>
                    </tr>
                    </thead>
                    <tbody>
                    <tr v-for="(item, index) in repositories">
                        <td>{# item.rep_id #}</td>
                        <td><a :href="item.rep_url">{# item.rep_name #}</a></td>
                        <td>{# item.language #}</td>
                        <td>{# item.rep_description #}</td>
                        <td><a href="#" class="text-primary">Edit</a></td>
                    </tr>
                    </tbody>
                </table>
            </div>
        </div>
    </div>

@endsection

@section('script')
    <script>
        new Vue({
            el: '#app',
            delimiters: ['{#', '#}'],
            data: {
                inputs: {
                    username: ''
                },
                repositories: []
            },
            methods: {
                submit: function () {
                    var self = this;
                    self.repositories = [];

                    axios.get('api/v1/repository/user-starred', {params: {'user': self.inputs.username}})
                        .then(function (value) {
                            self.repositories = value.data.data;
                        })
                        .catch(function (reason) {
                            console.log(reason.response.data.message);
                        })
                }
            }
        })
    </script>
@endsection