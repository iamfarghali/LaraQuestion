<div class="row justify-content-center mt-4" v-cloak>
    <div class="col-md-10">
        <div class="card">
            <div class="card-body">
                <div class="card-title">
                    <h2>{{$answersCount. " " . \Str::plural('Answer', $answersCount )}}</h2>
                </div>
                <hr>
                @include('layouts._message')
                @foreach($answers as $answer)
                    <answer :answer="{{$answer}}" inline-template>
                        <div class="media" style="border-bottom: 1px solid #f2f2f2; padding: 1rem;">
                            <vote :model="{{$answer}}" name="answer"></vote>
                            <div class="media-body">
                                {{-- Editing Form --}}
                                <form v-if="editing" @submit.prevent="update">
                                    <div class="form-group">
                                        <label for="body">Your Answer</label>
                                        <textarea v-model="body" class="form-control" name="body" id="body"
                                                  rows="10"></textarea>
                                    </div>
                                    <button class="btn btn-primary btn-sm" type="submit" :disabled="isInvalid">Update
                                    </button>
                                    <button class="btn btn-outline-danger btn-sm" type="button" @click="cancel">Cancel
                                    </button>
                                </form>
                                <div v-else>
                                    <div v-html="bodyHtml"></div>
                                    <div class="row">
                                        <div class="col-md-4">
                                            @can('update', $answer)
                                                <a @click.prevent="edit" href="#"
                                                   class="btn btn-primary btn-sm">Edit</a>
                                            @endcan
                                            @can('delete', $answer)
                                                <button @click="destroy" class="d-inline btn btn-outline-danger btn-sm">
                                                    Delete
                                                </button>
                                            @endcan
                                        </div>
                                        <div class="col-md-4"></div>
                                        <div class="col-md-4">
                                            <author-info :model="{{$answer}}" label="Answered"></author-info>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </answer>
                @endforeach
            </div>
        </div>
    </div>
</div>
