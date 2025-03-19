@extends('templates.main')

@section('title_page')
    Equipment Photos
@endsection

@section('breadcrumb_title')
    <a href="{{ route('equipments.index') }}">equipments</a>
@endsection

@section('content')
    <div class="row">
        <div class="col-12">
            <!-- Top action bar -->
            <div class="d-flex justify-content-between align-items-center mb-3 animated fadeIn">
                <h3 class="text-dark">
                    <i class="fas fa-images mr-2"></i> Equipment Photos
                    <span class="badge badge-primary">{{ $equipment->unit_no }}</span>
                </h3>
                <div>
                    <a href="{{ route('equipments.show', $equipment->id) }}" class="btn btn-info btn-hover-effect">
                        <i class="fas fa-info-circle"></i> Equipment Details
                    </a>
                    <a href="{{ route('equipments.index') }}" class="btn btn-primary ml-2 btn-hover-effect">
                        <i class="fas fa-arrow-left"></i> Back to Equipment List
                    </a>
                </div>
            </div>

            <!-- Equipment Photos Gallery Card -->
            <div class="card card-primary card-outline shadow-sm animated fadeIn delay-1">
                <div class="card-header">
                    <h3 class="card-title">
                        <i class="fas fa-image mr-2"></i> Photo Gallery
                    </h3>
                    <div class="card-tools">
                        <button type="button" class="btn btn-tool" data-card-widget="collapse">
                            <i class="fas fa-minus"></i>
                        </button>
                    </div>
                </div>

                <div class="card-header bg-light">
                    <button type="button" class="btn btn-primary btn-hover-effect" data-toggle="modal"
                        data-target="#createPhoto">
                        <i class="fas fa-plus mr-1"></i> Add New Photo
                    </button>
                </div>

                <div class="card-body">
                    @if (count($photos) > 0)
                        <div class="row photo-gallery">
                            @foreach ($photos as $photo)
                                <div class="col-lg-2 col-md-3 col-sm-4 col-6 mb-4 animated fadeIn">
                                    <div class="photo-card position-relative shadow-sm rounded">
                                        <a href="{{ asset('images') . '/' . $photo->filename }}" data-toggle="lightbox"
                                            data-title="{{ $photo->description ?: 'Equipment Photo' }}"
                                            data-gallery="equipment-gallery" class="photo-link">
                                            <img src="{{ asset('images') . '/' . $photo->filename }}"
                                                class="img-fluid rounded" alt="image-{{ $photo->id }}" loading="lazy" />
                                            <div class="photo-overlay">
                                                <i class="fas fa-search-plus"></i>
                                            </div>
                                        </a>
                                        <div class="photo-actions">
                                            <form action="{{ route('equipments.photos.destroy', $photo->id) }}"
                                                method="POST" class="delete-form">
                                                @csrf
                                                @method('DELETE')
                                                <input type="hidden" name="equipment_id" value="{{ $photo->id }}">
                                                <button type="submit"
                                                    class="btn btn-danger btn-sm btn-hover-effect delete-btn"
                                                    data-toggle="tooltip" title="Delete Photo"
                                                    onclick="return confirm('Are you sure you want to delete this photo?')">
                                                    <i class="fas fa-trash"></i>
                                                </button>
                                            </form>
                                        </div>
                                        @if ($photo->description)
                                            <div class="photo-caption">
                                                {{ $photo->description }}
                                            </div>
                                        @endif
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    @else
                        <div class="empty-state text-center py-5 animated fadeIn">
                            <img src="{{ asset('adminlte/dist/img/photo1.png') }}" alt="No Photos" class="img-fluid mb-3"
                                style="max-height: 150px; opacity: 0.5;">
                            <h5 class="text-muted">No photos available</h5>
                            <p class="text-muted">Click "Add New Photo" button to upload photos of this equipment</p>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>

    <!-- Upload Photo Modal -->
    <div class="modal fade" id="createPhoto">
        <div class="modal-dialog modal-md">
            <div class="modal-content animated fadeInUp faster">
                <div class="modal-header bg-primary text-white">
                    <h5 class="modal-title">
                        <i class="fas fa-upload mr-2"></i> Upload New Photo
                    </h5>
                    <button type="button" class="close text-white" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <form action="{{ route('equipments.photos.store', $equipment->id) }}" method="POST"
                    enctype="multipart/form-data" id="photo-upload-form">
                    @csrf
                    <div class="modal-body">
                        <div class="form-group">
                            <label for="description" class="col-form-label">
                                <i class="fas fa-comment mr-1"></i> Description <small class="text-muted">(optional)</small>
                            </label>
                            <input type="text" name="description" id="description" class="form-control"
                                placeholder="Enter photo description">
                        </div>
                        <div class="form-group">
                            <label for="file_upload" class="col-form-label">
                                <i class="fas fa-file-image mr-1"></i> Photo File <span class="text-danger">*</span>
                            </label>
                            <div class="input-group">
                                <div class="custom-file">
                                    <input type="file" name="file_upload" id="file_upload" class="custom-file-input"
                                        accept="image/*" required>
                                    <label class="custom-file-label" for="file_upload">Choose file</label>
                                </div>
                            </div>
                            <small class="form-text text-muted">
                                Supported formats: JPG, PNG, GIF (Max size: 1MB)
                            </small>
                        </div>
                        <div class="mt-3" id="image-preview-container" style="display: none;">
                            <label class="col-form-label">Preview:</label>
                            <div class="text-center p-3 bg-light rounded">
                                <img id="image-preview" class="img-fluid rounded shadow-sm" style="max-height: 200px;" />
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer justify-content-between bg-light">
                        <button type="button" class="btn btn-default btn-hover-effect" data-dismiss="modal">
                            <i class="fas fa-times mr-1"></i> Cancel
                        </button>
                        <button type="submit" class="btn btn-primary btn-hover-effect">
                            <i class="fas fa-upload mr-1"></i> Upload Photo
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection

@section('styles')
    <link rel="stylesheet" href="{{ asset('adminlte/plugins/ekko-lightbox/ekko-lightbox.css') }}">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/4.1.1/animate.min.css" />
    <style>
        /* Photo gallery styles */
        .photo-gallery {
            margin: 0 -10px;
        }

        .photo-card {
            position: relative;
            overflow: hidden;
            height: 150px;
            transition: all 0.3s ease;
            border: 1px solid rgba(0, 0, 0, 0.125);
        }

        .photo-card:hover {
            transform: translateY(-5px);
            box-shadow: 0 5px 15px rgba(0, 0, 0, 0.1) !important;
        }

        .photo-card img {
            width: 100%;
            height: 100%;
            object-fit: cover;
        }

        .photo-overlay {
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            background-color: rgba(0, 0, 0, 0.4);
            display: flex;
            align-items: center;
            justify-content: center;
            opacity: 0;
            transition: opacity 0.3s ease;
            color: white;
            font-size: 1.5rem;
        }

        .photo-card:hover .photo-overlay {
            opacity: 1;
        }

        .photo-actions {
            position: absolute;
            top: 10px;
            right: 10px;
            opacity: 0;
            transition: opacity 0.3s ease;
        }

        .photo-card:hover .photo-actions {
            opacity: 1;
        }

        .photo-caption {
            position: absolute;
            bottom: 0;
            left: 0;
            right: 0;
            padding: 5px 10px;
            background-color: rgba(0, 0, 0, 0.7);
            color: white;
            font-size: 0.8rem;
            text-overflow: ellipsis;
            white-space: nowrap;
            overflow: hidden;
        }

        /* Button effects */
        .btn-hover-effect {
            transition: all 0.3s ease;
        }

        .btn-hover-effect:hover {
            transform: translateY(-2px);
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
        }

        /* Animations */
        .animated {
            animation-duration: 0.7s !important;
        }

        .delay-1 {
            animation-delay: 0.2s;
        }

        .faster {
            animation-duration: 0.5s !important;
        }

        /* Lightbox customization */
        .ekko-lightbox .modal-dialog {
            max-width: 80%;
        }

        .ekko-lightbox-nav-overlay a {
            opacity: 0.8;
            color: white;
            text-shadow: 0 0 10px rgba(0, 0, 0, 0.5);
        }

        /* Empty state styling */
        .empty-state {
            background-color: #f8f9fa;
            border-radius: 5px;
        }

        /* Modal styling */
        .modal-header.bg-primary {
            background-color: #007bff !important;
        }

        /* Responsive layout improvements */
        @media (max-width: 767.98px) {
            .photo-card {
                height: 120px;
            }

            .card-header {
                padding: 0.75rem 1rem;
            }

            .photo-actions .btn {
                padding: 0.25rem 0.5rem;
                font-size: 0.7rem;
            }
        }
    </style>
@endsection

@section('scripts')
    <script src="{{ asset('adminlte/plugins/ekko-lightbox/ekko-lightbox.min.js') }}"></script>
    <script src="{{ asset('adminlte/plugins/bs-custom-file-input/bs-custom-file-input.min.js') }}"></script>
    <script>
        $(function() {
            // Initialize Lightbox
            $(document).on('click', '[data-toggle="lightbox"]', function(event) {
                event.preventDefault();
                $(this).ekkoLightbox({
                    alwaysShowClose: true,
                    showArrows: true,
                    leftArrow: '<i class="fas fa-chevron-left"></i>',
                    rightArrow: '<i class="fas fa-chevron-right"></i>'
                });
            });

            // Initialize custom file input
            bsCustomFileInput.init();

            // Image preview
            $('#file_upload').on('change', function() {
                const file = this.files[0];
                if (file) {
                    const reader = new FileReader();
                    reader.onload = function(e) {
                        $('#image-preview').attr('src', e.target.result);
                        $('#image-preview-container').fadeIn();
                    }
                    reader.readAsDataURL(file);
                } else {
                    $('#image-preview-container').hide();
                }
            });

            // Tooltips
            $('[data-toggle="tooltip"]').tooltip();

            // Animate photos on page load
            let delay = 0;
            $('.photo-gallery .col-lg-2').each(function() {
                $(this).css('animation-delay', delay + 's');
                delay += 0.1;
            });

            // Form validation
            $('#photo-upload-form').on('submit', function(e) {
                const fileInput = $('#file_upload')[0];
                if (fileInput.files.length === 0) {
                    e.preventDefault();
                    alert('Please select a photo to upload');
                    return false;
                }

                const fileSize = fileInput.files[0].size / 1024 / 1024; // in MB
                if (fileSize > 1) {
                    e.preventDefault();
                    alert('File size exceeds 1MB. Please select a smaller file.');
                    return false;
                }

                return true;
            });
        });
    </script>
@endsection
