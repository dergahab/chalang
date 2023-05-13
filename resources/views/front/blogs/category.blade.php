<div class="widget widget-categories">
    <h4 class="widget-title">Categories</h4>
    <ul class="category-list list-unstyled">
        @foreach ($categories as $category)
            <li><a href="blog-category.html">{{$category->name}}</a></li>                                        
        @endforeach
    </ul>
</div>