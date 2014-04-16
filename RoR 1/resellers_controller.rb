class ResellersController < ApplicationController
	before_filter :signed_in_example, only: [:edit, :update, :show]
  
  def index
  	redirect_to root_url
  end
  
  def new
  	if signed_in_user?
  		redirect_to user_path(current_user)
  	elsif signed_in_example?
  		redirect_to example_path(current_example)
  	else	
  		@reseller = Reseller.new
  	end
  end
  
  def show
  	@reseller = Reseller.find(params[:id])
  end 
  
  def create
  	if Reseller.find_by_contact_email( params[:reseller][:contact_email] )
  		flash[:error] = "Application Already Submitted."
  		redirect_to register_error_url
  	else	
#  		if params[:reseller][:company_region]
#	  		params[:reseller][:example_id] = Example.find_by_region( params[:reseller][:company_region] ).id
#	  	end
	  	@reseller = Reseller.new(params[:reseller])
	  	#@user = User.new(:name => params[:reseller][:contact_name], :email => params[:reseller][:contact_email], :validate_url => SecureRandom.urlsafe_base64, :validate_code => SecureRandom.urlsafe_base64, :remember_token => SecureRandom.urlsafe_base64, :validated => false, :admin => false, :reseller_id => @reseller.id, :password => "Password", :password_confirmation => "Password")
	    if @reseller.save
	    	ResellerMailer.welcome_email(@reseller).deliver
		  	flash[:success] = "ResellerConnect Application Submitted!"
		  	redirect_to completed_url
	    else
	    	render 'new'
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
      
end
