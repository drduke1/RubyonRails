class ImagesController < ApplicationController

	def index
		@images = Image.all
	end
	
  def new
  	@image = Image.new
  end

  def create
  	@image = Image.new(params[:image])
    if @image.save
    	flash[:success] = "Image Uploaded!"
    	redirect_to grandstreamers_images_path
    else
    	render 'new'
    end
  end

  def edit
  end

  def show
  end

  def destroy
  end
  
end

