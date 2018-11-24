# weibo
a simple weibo using redis


微博模型

全局维护着：useID，postID，globalstore，


每个用户维持着一个关注集合，被关注集合。
                                             










对于每一个用户来说，维护着一个拉取微博的，lastpullid:userid，然后获取，关注集合里的人物（包括自己的）的从lastpullid:userid到全局维护的“微博指针ID：postID”，这里去的是userpost这个只包含20条数据的个人微博链表，并将每一个关注的人的20条微博放到一个recivepost的链表里面，这个链表只保持999条数据，然后从这里取出来，在主页展示。


个人信息，微博信息都可以使用hash数据结构或者字符结构，哪种方便方便哪种来。

最后将这个内容存储到实际的数据库里面，用到全局表里globalstore这个链表。
