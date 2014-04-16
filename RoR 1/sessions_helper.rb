module SessionsHelper

	# For examples

	def sign_in_example(example)
		cookies[:remember_token] = example.remember_token
		self.current_example = example
	end
	
	def signed_in_example?
		!current_example.nil?
	end
	
	def current_example=(example)
		@current_example = example
	end 
	
	def current_example
		@current_example ||= Example.find_by_remember_token(cookies[:remember_token])
	end
	
	def current_example?(example)
		example == current_example
	end
	
	def sign_out_example
		self.current_example = nil
		cookies.delete(:remember_token)
	end

	def admin_example
		redirect_to(@example) unless current_example.admin?
	end
	
	def admin_example?
		current_example.admin?
	end
	
	# For Resellers User
	
	def sign_in_user(user)
		cookies[:remember_token] = user.remember_token
		self.current_user = user
	end
	
	def signed_in_user?
		!current_user.nil?
	end
	
	def current_user=(user)
		@current_user = user
	end 
	
	def current_user
		@current_user ||= User.find_by_remember_token(cookies[:remember_token])
	end
	
	def current_user?(user)
		user == current_user
	end
	
	def sign_out_user
		self.current_user = nil
		cookies.delete(:remember_token)
	end

	def admin_user
		redirect_to(current_user) unless current_user.admin?
	end
	
	def admin_user?
		current_user.admin?
	end
	
	# Universal
	
	def redirect_back_or(default)
		redirect_to(session[:return_to] || default)
		session.delete(:return_to)
	end
	
	def store_location
		session[:return_to] = request.url
	end

end