class DistributorsController < ApplicationController
  
  before_filter :signed_in_distributor,  only: [:edit, :update, :show, :index]
  before_filter :correct_distributor,    only: [:edit, :update, :show, :change_password]
  
  def index
    @distributors = Distributor.paginate(page: params[:page])
    
  	redirect_to root_url
  end
  
  def new
  	if signed_in_distributor?
  		redirect_to distributor_path(current_distributor)
  	elsif signed_in_example?
  		redirect_to example_path(current_example)
  	else	
  		@distributor = Distributor.new
  	end
  end
  
  def show
    if current_example
    @example_distributor = Distributor.find_all_by_company_region(current_example.region, true)
    end
  end 
  
  def create
  	if Distributor.find_by_contact_email( params[:distributor][:contact_email] )
  		flash[:error] = "Partner's Email Already Submitted."
  		redirect_to register_error_url
  	else
      @distributor = Distributor.new(params[:distributor])
      @distributor.company_region = current_example.region
	  	if @distributor.save	  	  
	    	DistributorMailer.welcome_email(@distributor).deliver
		  	flash[:success] = "Certified Partner Added"
        redirect_to example_path(current_example)
	    else
	    	redirect_to examples_new_path
	    end
  	end
	  	
  end
  
  def edit
      render 'edit'
    end
  
  def update
    
      if params[:distributor][:current_password]
        if current_distributor.authenticate(params[:distributor][:current_password])
          if @distributor.update_attribute(:password, params[:distributor][:password])
            flash[:success] = "Password successfully changed"
            sign_in_distributor @distributor
            redirect_to @distributor
          else
            render 'edit'
          end
        else
          flash[:error] = "Current Password does not match what you've entered"
          render 'change_password'
        end
      else
        if @distributor.update_attributes(params[:distributor])
          flash[:success] = "Profile updated"
          redirect_to :back
        else
          render 'edit'
        end
      end
    end
    
  def destroy
    
  end
    
  def change_password
      @distributor = current_distributor
    end
    
  def update_password
      if current_distributor.authenticate(params[:distributor][:current_password])
        if @distributor.update_attributes(params[:distributor][:password], params[:distributor][:password_confirmation])
          flash[:success] = "Password successfully changed"
          redirect_to current_distributor
        else
          render 'edit'
        end
      else
        flash[:error] = "Current Password does not match what you've entered"
        render 'change_password'
      end
    end
    
  def marketing
      @distributor = current_distributor
    end
    
    def create_signin
      if signed_in_distributor?
        redirect_to current_distributor
      else
        if params[:code]
          if Distributor.find_by_validate_url(params[:code])
            @distributor = Distributor.find_by_validate_url(params[:code])
          else
            redirect_to root_url
          end
        else
          redirect_to root_url
        end
      end
    end
  
  private
      
  def signed_in_example
        unless signed_in_example?
          store_location
          redirect_to signin_url, notice: "Please sign in." unless signed_in_example?
        end
      end
  
      def signed_in_distributor
        unless signed_in_distributor?
          store_location
          redirect_to signin_url, notice: "Please sign in." unless signed_in_distributor?
        end
      end
      
      def correct_distributor
        @distributor = Distributor.find(params[:id])
        redirect_to(current_distributor) unless current_distributor?(@distributor) || admin_distributor?
      end
      
  end
