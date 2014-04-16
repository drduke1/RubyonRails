class ResellerMailer < ActionMailer::Base
  default from: "x"
  
  def welcome_email(reseller)
    @reseller = reseller
    @emea_email = "x"
    
    example = Example.find_by_id(reseller.example_id)
    
    if reseller.company_region == "EMEA"
    	mail(:to => reseller.contact_email, :subject => "X Registration", :bcc => emea_email)
    else
    	mail(:to => reseller.contact_email, :subject => "X Registration")
    end

  end
end
