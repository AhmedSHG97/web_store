<!DOCTYPE html>
<html>

{{-- Header --}}
    @include("website.layouts.header")
{{-- #END# Header --}}

<body class="theme-red">

    <!-- Page Loader -->
    @include("website.layouts.page_loader")
    <!-- #END# Page Loader -->

    <!-- Overlay For Sidebars -->
    <div class="overlay"></div>
    <!-- #END# Overlay For Sidebars -->

    <!-- Search Bar -->
    @include("website.layouts.search_bar")
    <!-- #END# Search Bar -->
    
    <!-- Top Bar -->
    @include("website.layouts.top_navbar")
    <!-- #Top Bar -->

   
    <section>
        <!-- Left Sidebar -->
        @include('website.layouts.left_sidebar')
        <!-- #END# Left Sidebar -->
       
        <!-- Right Sidebar -->
        @include("website.layouts.right_sidebar")
        <!-- #END# Right Sidebar -->
    </section>

    <section class="content">
        {{-- Messages --}}
        @include("website.layouts.messages")
        {{-- #END# Messages --}}

        {{-- Content --}}
        @yield("content")
        {{-- #END# Content --}}
    </section>
    {{-- Footer --}}
    @include("website.layouts.footer")
    {{-- #END# Footer --}}
</body>

</html>