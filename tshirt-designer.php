<?php
/*
Plugin Name: T-Shirt Designer
Description: A drag-and-drop T-shirt designer tool with Bootstrap.
Version: 1.1
Author: Your Name
*/

function tshirt_designer_enqueue_scripts()
{
    wp_enqueue_style('bootstrap-css', 'https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css');
    wp_enqueue_style('tshirt-designer-style', plugins_url('assets/css/style.css', __FILE__));
    wp_enqueue_script('bootstrap-js', 'https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js', array('jquery'), null, true);
    wp_enqueue_script('tshirt-designer-script', plugins_url('assets/js/dragdrop.js', __FILE__), array('jquery'), null, true);
}
add_action('wp_enqueue_scripts', 'tshirt_designer_enqueue_scripts');

function tshirt_designer_html()
{
    ob_start();
?>
    <div class="container my-5">
        <div class="row g-4">
            <!-- T-Shirt Preview Section -->
            <div class="col-md-6">
                <div class="card shadow-sm">
                    <div class="card-header bg-primary text-white text-center">
                        <h5 class="mb-0">T-Shirt Preview</h5>
                    </div>
                    <div class="card-body text-center">
                        <div class="tshirt-preview position-relative border rounded p-3">
                            <canvas id="tshirt-canvas" class="border"></canvas>
                            <img src="<?php echo plugins_url('assets/images/plain-tshirt.png', __FILE__); ?>" id="tshirt-image" class="d-none" alt="T-Shirt" />
                            <img id="logo-image" class="d-none draggable" alt="Logo" />
                        </div>
                    </div>
                </div>
            </div>

            <!-- Customization Section -->
            <div class="col-md-6">
                <div class="card shadow-sm">
                    <div class="card-header bg-success text-white">
                        <h5 class="mb-0">Customize Your T-Shirt</h5>
                    </div>
                    <div class="card-body">
                        <div class="accordion" id="customizationAccordion">
                            <!-- Select Text or Image -->
                            <div class="accordion-item">
                                <h2 class="accordion-header" id="headingSelectElement">
                                    <button class="accordion-button" type="button" data-bs-toggle="collapse" data-bs-target="#collapseSelectElement" aria-expanded="true" aria-controls="collapseSelectElement">
                                        Select Element to Customize
                                    </button>
                                </h2>
                                <div id="collapseSelectElement" class="accordion-collapse collapse show" aria-labelledby="headingSelectElement">
                                    <div class="accordion-body">
                                        <label for="select-element" class="form-label">Choose Element To Drag:</label>
                                        <select id="select-element" class="form-select">
                                            <option value="text">Text</option>
                                            <option value="image">Image</option>
                                        </select>
                                    </div>
                                </div>
                            </div>

                            <!-- T-Shirt Color Picker -->
                            <div class="accordion-item">
                                <h2 class="accordion-header" id="headingColor">
                                    <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapseColor" aria-expanded="false" aria-controls="collapseColor">
                                        T-Shirt Color
                                    </button>
                                </h2>
                                <div id="collapseColor" class="accordion-collapse collapse" aria-labelledby="headingColor">
                                    <div class="accordion-body">
                                        <input type="color" id="tshirt-color" class="form-control form-control-color" value="#ffffff" />
                                    </div>
                                </div>
                            </div>

                            <!-- Logo Options -->
                            <div class="accordion-item">
                                <h2 class="accordion-header" id="headingLogo">
                                    <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapseLogo" aria-expanded="false" aria-controls="collapseLogo">
                                        Logo Options
                                    </button>
                                </h2>
                                <div id="collapseLogo" class="accordion-collapse collapse" aria-labelledby="headingLogo">
                                    <div class="accordion-body">
                                        <label for="logo-size" class="form-label">Logo Size:</label>
                                        <input type="range" id="logo-size" class="form-range" min="10" max="200" value="80" />
                                        <span id="logo-size-value">80 px</span>

                                        <label for="logo-upload" class="form-label mt-3">Upload a Logo:</label>
                                        <input type="file" id="logo-upload" class="form-control" accept="image/*" />
                                    </div>
                                </div>
                            </div>

                            <!-- Text Options -->
                            <div class="accordion-item">
                                <h2 class="accordion-header" id="headingText">
                                    <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapseText" aria-expanded="false" aria-controls="collapseText">
                                        Text Options
                                    </button>
                                </h2>
                                <div id="collapseText" class="accordion-collapse collapse" aria-labelledby="headingText">
                                    <div class="accordion-body">
                                        <label for="custom-text" class="form-label">Enter Custom Text:</label>
                                        <input type="text" id="custom-text" class="form-control" placeholder="Type your text here" />

                                        <label for="font-family" class="form-label mt-3">Choose Font:</label>
                                        <select id="font-family" class="form-select">
                                            <option value="Arial">Arial</option>
                                            <option value="Courier New">Courier New</option>
                                            <option value="Georgia">Georgia</option>
                                            <option value="Times New Roman">Times New Roman</option>
                                            <option value="Verdana">Verdana</option>
                                        </select>

                                        <label for="text-size" class="form-label mt-3">Text Size:</label>
                                        <input type="range" id="text-size" class="form-range" min="10" max="100" value="30" />
                                        <span id="text-size-value">30 px</span>

                                        <label for="text-color" class="form-label mt-3">Text Color:</label>
                                        <input type="color" id="text-color" class="form-control form-control-color" value="#000000" />
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
<?php
    return ob_get_clean();
}

add_shortcode('tshirt_designer', 'tshirt_designer_html');
