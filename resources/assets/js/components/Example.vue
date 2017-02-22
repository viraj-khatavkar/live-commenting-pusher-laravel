<template>
<div class="container">
    <div class="row">
    <div class="col-sm-5">
            <div class="panel panel-primary">
                <div class="panel-heading" id="accordion">
                    <span class="glyphicon glyphicon-comment"></span> Chat
                    <div class="btn-group pull-right">
                        <a type="button" class="btn btn-default btn-xs" data-toggle="collapse" data-parent="#accordion" href="#collapseOne">
                            <span class="glyphicon glyphicon-chevron-down"></span>
                        </a>
                    </div>
                </div>
            <div class="panel-collapse collapse" id="collapseOne">
                <div class="panel-body">
                    <ul class="chat">
                        <li class="left clearfix" v-for="comment in comments">
                        <span class="chat-img pull-left">
                            <img src="http://placehold.it/50/55C1E7/fff&text=U" alt="User Avatar" class="img-circle" />
                        </span>
                            <div class="chat-body clearfix">
                                <div class="header">
                                    <strong class="primary-font">{{ comment.user.name }}</strong> <small class="pull-right text-muted">
                                        <span class="glyphicon glyphicon-time"></span>12 mins ago</small>
                                </div>
                                <p>
                                    {{ comment.body }}
                                </p>
                            </div>
                        </li>
                    </ul>
                </div>
                <div class="panel-footer">
                    <div class="input-group">
                        <input id="btn-input" type="text" class="form-control input-sm" placeholder="Type your message here..." v-model="body" @keyup.enter="postComment()" autofocus />
                        <span class="input-group-btn">
                            <button class="btn btn-warning btn-sm" id="btn-chat" @click.prevent="postComment()">
                                Send</button>
                        </span>
                    </div>
                </div>
            </div>
            </div>
        </div>
        <div class="col-sm-7">
            <iframe width="640" height="280" src="https://www.youtube.com/embed/Xip2TgAEVz4" frameborder="0" allowfullscreen></iframe>
        </div>
    </div>
    <div class="row">
        <div class="col-sm-12">
            <h1>
                {{ count }} watching now
            </h1>
        </div>
    </div>
</div>
</template>

<script>
    export default {
        props: ['user', 'video'],
        data() {
            return {
                viewers: [],
                comments: [],
                body: '',
                count: 0
            }
        },
        mounted() {
            this.listen();
            this.getComments();
        },
        methods: {
            getComments() {
                axios.get('/api/videos/'+ this.video.id +'/comments?api_token=' + this.user.api_token, {})
                .then((response) => {
                    this.comments = response.data;
                });
            },
            postComment() {
                axios.post('/api/videos/'+ this.video.id +'/comment?api_token=' + this.user.api_token, {
                    body: this.body
                })
                .then((response) => {
                    this.body= '';
                    this.comments.unshift(response.data);
                });
            },
            listen() {
                Echo.join('video')
                    .here((users) => {
                        this.count = users.length;
                    })
                    .joining((user) => {
                        this.count++;
                    })
                    .leaving((user) => {
                        this.count--;
                    })
                    .listen('NewComment', (e) => {
                        this.comments.unshift(e);
                    });
            }
        }
    }
</script>