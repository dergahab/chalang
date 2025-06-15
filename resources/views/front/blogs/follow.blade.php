<div class="widget widge-social-share">
    <div class="blog-share">
        <h5 class="title">{{__('front.follow')}}</h5>
        <ul class="social-list list-unstyled">
            @foreach($socialmedia as $item)
                <li>
                    <a href="{{ $item->url }}" target="_blank">
                        <i class="{{ $item->icon }}"></i>
                    </a>
                </li>
            @endforeach
        </ul>
    </div>
</div>
