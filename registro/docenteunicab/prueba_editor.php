<?php
    include "../adminunicab/php/conexion.php";
    require("updreg/1cc3s4db.php");
    header("Cache-Control: no-store");
    
    //$query_tc = "SELECT *  FROM certificado WHERE numero1 = 20204894 AND tipo_certificado = 'Certificado de notas'";
    //$exe_query_tc=mysqli_query($conexion,$query_tc);
    
    //Se crea la carpeta
    /*$path = 'dhonor/2021/'.str_replace(" ","_","GHF").'/';
    echo $path;
    if (!file_exists($path)) {
        mkdir($path, 0755, true);
        echo "control";
    }*/
?>

<html>
    <head>
		<meta charset="utf-8">
		<meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0" />
		<link type="text/css" href="ckeditor/ckeditor5/sample/css/sample.css" rel="stylesheet" media="screen" />
		
		<style>
            #container {
                width: 800px;
                margin: 20px auto;
            }
            .ck-editor__editable[role="textbox"] {
                /* editing area */
                min-height: 200px;
            }
        </style>
		
		<title>Unicab Registro Académico</title>
		<meta name="viewport" content="width=device-width, initial-scale=1">

		 <!-- Favicon -->
		<link rel="shortcut icon" href="../images/favicon.png" />
		<!-- // Favicon -->
		<script type="application/x-javascript"> addEventListener("load", function() { setTimeout(hideURLbar, 0); }, false); function hideURLbar(){ window.scrollTo(0,1); } </script>
		<!-- Bootstrap Core CSS -->
		<link href="../css/bootstrap.css" rel='stylesheet' type='text/css' />

		<!-- Custom CSS -->
		<link href="../css/style.css" rel='stylesheet' type='text/css' />

		<!-- font-awesome icons CSS -->
		<link href="../css/font-awesome.css" rel="stylesheet"> 
		<!-- //font-awesome icons CSS-->
		<!-- side nav css file -->
		<link href='../css/SidebarNav.min.css' media='all' rel='stylesheet' type='text/css'/>
		<!-- //side nav css file -->
		 <!-- js-->
		<script src="../js/jquery-1.11.1.min.js"></script>
		<script src="../js/modernizr.custom.js"></script>
		<!--webfonts-->
		<link href="//fonts.googleapis.com/css?family=PT+Sans:400,400i,700,700i&amp;subset=cyrillic,cyrillic-ext,latin-ext" rel="stylesheet">
		<!--//webfonts--> 
		<!--css tabla -->
		<link href="../css/jquery.dataTables.min.css" rel="stylesheet"> 
		<!-- // css tabla -->
		<!-- Metis Menu -->
		<script src="../js/metisMenu.min.js"></script>
		<script src="../js/custom.js"></script>
		<link href="../css/custom.css" rel="stylesheet">
		<!--//Metis Menu -->		
			
		<style>
			#chartdiv {
			  width: 100%;
			  height: 295px;
			}
			.maxl {
				color: blue;
			}
			#alert {
				position: fixed;
				bottom: 0;
				left: 180px;
				z-index: 5000;
				height: 80px;
			}
			#txtvacio {
				border: 0;
			}
			.error {
				border: 3px solid red !important;
			}
				
			input[type=checkbox] {
				visibility: hidden;
			}
			
			.checkbox-GHF {
				display: inline-block;
				position: relative;
				width: 70px;
				height: 30px;
				background: #F3F781;
				border-radius: 15px;
				box-shadow: inset 0px 1px 1px rgba(0,0,0,0.6), 0px 1px 0px rgba(255,255,255,0.3);   
			}
			
			.checkbox-GHF label {
			
				/* aspecto */
				display: block;
				width: 34px;
				height: 20px;
				border-radius: 17px;
				box-shadow: 0px 2px 5px 0px rgba(0,0,0,0.35);
				background: #fcfff4;
				background: linear-gradient(to top, #fcfff4 0%, #dfe5d7 40%, #b3bead 100%);
				cursor: pointer;
				
				/* Posicionamiento */
				position: absolute;
				top: 5px;
				left: 5px;
				z-index: 1;
				
				/* Comportamiento */
				transition: all .4s ease;
				
				/* ocultar el posible texto que tenga */
				overflow: hidden;
				text-indent: 35px;  
				transition: text-indent 0s;
			}
			
			/* estado activado */
			.checkbox-GHF input[type=checkbox]:checked + label {
				left: auto;
				right: 5px;
			}
			
			.checkbox-GHF:after {
				content: 'NO';
				font: 12px/30px Arial, sans-serif;
				color: red;
				position: absolute;
				right: 10px;
				z-index: 0;
				font-weight: bold;
				
			}
			
			.checkbox-GHF:before {
				content: 'SI';
				font: 12px/30px Arial, sans-serif;
				color: green;
				position: absolute;
				left: 10px;
				z-index: 0;
				font-weight: bold;
			}
		</style>
    </head>
    <body>
	<div class="main-content">
        <!--<main>
			<div class="centered">
				<div class="document-editor">
					<div class="toolbar-container"></div>
					<div class="content-container">
						<div id="editor">
							<h2>The three greatest things you learn from traveling</h2>
				
							<p>Like all the great things on earth traveling teaches us by example. Here are some of the most precious lessons I’ve learned over the years of traveling.</p>
				
							<h3>Appreciation of diversity</h3>
				
							<p>Getting used to an entirely different culture can be challenging. While it’s also nice to learn about cultures online or from books, nothing comes close to experiencing <a href="https://en.wikipedia.org/wiki/Cultural_diversity">cultural diversity</a> in person. You learn to appreciate each and every single one of the differences while you become more culturally fluid.</p>
				
							<figure class="image image-style-align-right"><img src="ckeditor/ckeditor5/sample/img/umbrellas.jpg" alt="Three Monks walking on ancient temple.">
								<figcaption>Leaving your comfort zone might lead you to such beautiful sceneries like this one.</figcaption>
							</figure>
				
							<h3>Confidence</h3>
				
							<p>Going to a new place can be quite terrifying. While change and uncertainty makes us scared, traveling teaches us how ridiculous it is to be afraid of something before it happens. The moment you face your fear and see there was nothing to be afraid of, is the moment you discover bliss.</p>
						</div>
					</div>
				</div>		
			</div>
		</main>-->
		
		<?php 
		    if($id == 18) {
	        require 'menu_adm.php';
		    }
		    else {
		        //require 'menu.php';
		        require 'menu_tutores.php';
		    }  
		?>
	
		<?php require 'header.php';  ?>
		
		<!-- modal -->
		<section>
			<?php require 'modal.php';  ?>
		</section>
		<!-- modal -->
		
		<section>
           	<div id="page-wrapper">
				<div class="forms">
					<div class="form-grids row widget-shadow" data-example-id="basic-forms"> 
						<div class="form-title">
							<h4>Crear nuevo blog:</h4>
						</div>
						<div class="form-body">
							<form action="prueba_editor_putdat.php" method="POST" id="form" name="form" enctype="multipart/form-data" target="_blank">

								<div id="container" class="form-group"> 
									<textarea name="editor" id="editor">
										
									</textarea>
								</div>

								<input type="hidden" class="form-control" name="IdEmp" value="<?php echo $id;?>" readonly>

								<button type="submit" id="btnguardar" class="btn btn-primary" >Guardar</button> 
								<button>prueba</button>
							</form>
						</div>
						
						<!--<div class="alert alert-danger" role="alert" id="alert">
                            <p><i class="fa fa-warning"></i><span>: </span><label id="lblmsg"></label>
                            <input type="text" class="alert alert-danger" style="width: 10px" id="txtvacio" value="0"></p>
                        </div>-->
                        
					</div>
           		</div>
      		</div>
		</section>
		
		<!--<div id="container">
            <div id="editor">
            </div>
        </div>-->
		
		<!--<script src="ckeditor/ckeditor5/ckeditor.js"></script>-->
		<script src="https://cdn.ckeditor.com/ckeditor5/36.0.1/super-build/ckeditor.js"></script>
		<script src="ckeditor/ckeditor5/translations/es.js"></script>

		<!--<script>
			DecoupledEditor
				.create( document.querySelector( '#editor' ), {
					// toolbar: [ 'heading', '|', 'bold', 'italic', 'link' ]
					language: 'es'
				} )
				.then( editor => {
					const toolbarContainer = document.querySelector( 'main .toolbar-container' );

					toolbarContainer.prepend( editor.ui.view.toolbar.element );

					window.editor = editor;
				} )
				.catch( err => {
					console.error( err.stack );
				} );
		</script>-->
		
		<script>
            // This sample still does not showcase all CKEditor 5 features (!)
            // Visit https://ckeditor.com/docs/ckeditor5/latest/features/index.html to browse all the features.
            CKEDITOR.ClassicEditor.create(document.getElementById("editor"), {
                // https://ckeditor.com/docs/ckeditor5/latest/features/toolbar/toolbar.html#extended-toolbar-configuration-format
                toolbar: {
                    items: [
                        //'exportPDF','exportWord', '|',
                        //'findAndReplace', 'selectAll', '|',
						'heading', '|',
                        //'bold', 'italic', 'strikethrough', 'underline', 'code', 'subscript', 'superscript', 'removeFormat', '|',
						'bold', 'italic', 'strikethrough', 'underline', 'code', 'subscript', 'superscript', '|',
                        'bulletedList', 'numberedList', 'todoList', '|',
                        'outdent', 'indent', '|',
                        'undo', 'redo',
                        '-',
                        'fontSize', 'fontFamily', 'fontColor', 'fontBackgroundColor', 'highlight', '|',
                        'alignment', '|',
                        //'link', 'insertImage', 'blockQuote', 'insertTable', 'mediaEmbed', 'codeBlock', 'htmlEmbed', '|',
						'link', 'insertImage', 'blockQuote', 'insertTable', 'mediaEmbed', '|',
                        //'specialCharacters', 'horizontalLine', 'pageBreak', '|',
						'horizontalLine', '|',
                        //'textPartLanguage', '|',
                        //'sourceEditing'
                    ],
                    shouldNotGroupWhenFull: true
                },
                // Changing the language of the interface requires loading the language file using the <script> tag.
                 language: 'es',
                list: {
                    properties: {
                        styles: true,
                        startIndex: true,
                        reversed: true
                    }
                },
                // https://ckeditor.com/docs/ckeditor5/latest/features/headings.html#configuration
                heading: {
                    options: [
                        { model: 'paragraph', title: 'Paragraph', class: 'ck-heading_paragraph' },
                        { model: 'heading1', view: 'h1', title: 'Heading 1', class: 'ck-heading_heading1' },
                        { model: 'heading2', view: 'h2', title: 'Heading 2', class: 'ck-heading_heading2' },
                        { model: 'heading3', view: 'h3', title: 'Heading 3', class: 'ck-heading_heading3' },
                        { model: 'heading4', view: 'h4', title: 'Heading 4', class: 'ck-heading_heading4' },
                        { model: 'heading5', view: 'h5', title: 'Heading 5', class: 'ck-heading_heading5' },
                        { model: 'heading6', view: 'h6', title: 'Heading 6', class: 'ck-heading_heading6' }
                    ]
                },
                // https://ckeditor.com/docs/ckeditor5/latest/features/editor-placeholder.html#using-the-editor-configuration
                placeholder: 'Ingrese el contenido del blog',
                // https://ckeditor.com/docs/ckeditor5/latest/features/font.html#configuring-the-font-family-feature
                fontFamily: {
                    options: [
                        'default',
                        'Arial, Helvetica, sans-serif',
                        'Courier New, Courier, monospace',
                        'Georgia, serif',
                        'Lucida Sans Unicode, Lucida Grande, sans-serif',
                        'Tahoma, Geneva, sans-serif',
                        'Times New Roman, Times, serif',
                        'Trebuchet MS, Helvetica, sans-serif',
                        'Verdana, Geneva, sans-serif'
                    ],
                    supportAllValues: true
                },
                // https://ckeditor.com/docs/ckeditor5/latest/features/font.html#configuring-the-font-size-feature
                fontSize: {
                    options: [ 10, 12, 14, 'default', 18, 20, 22 ],
                    supportAllValues: true
                },
                // Be careful with the setting below. It instructs CKEditor to accept ALL HTML markup.
                // https://ckeditor.com/docs/ckeditor5/latest/features/general-html-support.html#enabling-all-html-features
                htmlSupport: {
                    allow: [
                        {
                            name: /.*/,
                            attributes: true,
                            classes: true,
                            styles: true
                        }
                    ]
                },
                // Be careful with enabling previews
                // https://ckeditor.com/docs/ckeditor5/latest/features/html-embed.html#content-previews
                /*htmlEmbed: {
                    showPreviews: true
                },*/
                // https://ckeditor.com/docs/ckeditor5/latest/features/link.html#custom-link-attributes-decorators
                link: {
                    decorators: {
                        addTargetToExternalLinks: true,
                        defaultProtocol: 'https://',
                        toggleDownloadable: {
                            mode: 'manual',
                            label: 'Downloadable',
                            attributes: {
                                download: 'file'
                            }
                        }
                    }
                },
                // https://ckeditor.com/docs/ckeditor5/latest/features/mentions.html#configuration
                /*mention: {
                    feeds: [
                        {
                            marker: '@',
                            feed: [
                                '@apple', '@bears', '@brownie', '@cake', '@cake', '@candy', '@canes', '@chocolate', '@cookie', '@cotton', '@cream',
                                '@cupcake', '@danish', '@donut', '@dragée', '@fruitcake', '@gingerbread', '@gummi', '@ice', '@jelly-o',
                                '@liquorice', '@macaroon', '@marzipan', '@oat', '@pie', '@plum', '@pudding', '@sesame', '@snaps', '@soufflé',
                                '@sugar', '@sweet', '@topping', '@wafer'
                            ],
                            minimumCharacters: 1
                        }
                    ]
                },*/
                // The "super-build" contains more premium features that require additional configuration, disable them below.
                // Do not turn them on unless you read the documentation and know how to configure them and setup the editor.
                removePlugins: [
                    // These two are commercial, but you can try them out without registering to a trial.
                    // 'ExportPdf',
                    // 'ExportWord',
                    'CKBox',
                    'CKFinder',
                    'EasyImage',
                    // This sample uses the Base64UploadAdapter to handle image uploads as it requires no configuration.
                    // https://ckeditor.com/docs/ckeditor5/latest/features/images/image-upload/base64-upload-adapter.html
                    // Storing images as Base64 is usually a very bad idea.
                    // Replace it on production website with other solutions:
                    // https://ckeditor.com/docs/ckeditor5/latest/features/images/image-upload/image-upload.html
                    // 'Base64UploadAdapter',
                    'RealTimeCollaborativeComments',
                    'RealTimeCollaborativeTrackChanges',
                    'RealTimeCollaborativeRevisionHistory',
                    'PresenceList',
                    'Comments',
                    'TrackChanges',
                    'TrackChangesData',
                    'RevisionHistory',
                    'Pagination',
                    'WProofreader',
                    // Careful, with the Mathtype plugin CKEditor will not load when loading this sample
                    // from a local file system (file://) - load this site via HTTP server if you enable MathType
                    'MathType'
                ]
            });
        </script>
		
		<!--footer-->
		<?php require 'footer.php'; ?>
	    <!--//footer-->
	</div>	
    </body>
	<!-- Classie --><!-- for toggle left push menu script -->
	<script src="../js/classie.js"></script>
	<script>
		var menuLeft = document.getElementById( 'cbp-spmenu-s1' ),
			showLeftPush = document.getElementById( 'showLeftPush' ),
			body = document.body;
			
		showLeftPush.onclick = function() {
			classie.toggle( this, 'active' );
			classie.toggle( body, 'cbp-spmenu-push-toright' );
			classie.toggle( menuLeft, 'cbp-spmenu-open' );
			disableOther( 'showLeftPush' );
		};
		

		function disableOther( button ) {
			if( button !== 'showLeftPush' ) {
				classie.toggle( showLeftPush, 'disabled' );
			}
		}
	</script>
	<!-- //Classie --><!-- //for toggle left push menu script -->
		
	<!--scrolling js-->
	<script src="../js/jquery.nicescroll.js"></script>
	<script src="../js/scripts.js"></script>
	<!--//scrolling js-->
	
	<!-- side nav js -->
	<script src='../js/SidebarNav.min.js' type='text/javascript'></script>
	<script>
      $('.sidebar-menu').SidebarNav()
    </script>
	<!-- //side nav js -->
    
    <!-- js tabla -->
	<script src="../js/jquery.dataTables.min.js"></script>
	<script type="text/javascript">
		$(document).ready(function() {
    	$('#listEstudiantes').DataTable();	
		} );
	</script>
	<!-- //js tabla -->

	<!-- Bootstrap Core JavaScript -->
   	<script src="../js/bootstrap.js"> </script>
	<!-- //Bootstrap Core JavaScript -->
</html>